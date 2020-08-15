<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Carbon\Carbon;
use App\Models\UserVerificationEmail;

//Events
use App\Events\NewUser;
use App\Events\UserForgotPassword;
use App\Events\UserChangePassword;

//Models
use App\Models\ResetPassword;
use App\User;
use App\Models\CompanyData;
use App\Models\UserDataLogs;

class UserController extends Controller
{
    public function login(Request $req)
    {
        $credentials = $req->only('email', 'password');

        try {
            if (!$token = JWTAuth::attempt($credentials)) {
                return sendResponse([
                    'message' => 'Invalid credentials'
                ], 401);
            }
        } catch (JWTException $e) {
            return sendResponse([
                'message' => 'Failed to create token'
            ], 500);
        }

        $userData = JWTAuth::user($token);
        if(!$userData->email_verified_at){
            return sendResponse([
                'message' => 'Please activate your account before using the services'
            ], 401);
        }

        return sendResponse(compact('token'), 200);
    }

    public function register(Request $req)
    {
        $validator = Validator::make($req->all(), [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'required',
            'password' => 'required|string|min:6|confirmed'
        ]);

        if($validator->fails()){
            return sendResponse([
                'message' => $validator->errors()->first()
            ], 400);
        }

        $user = User::create([
            'first_name' => $req->get('first_name'),
            'last_name' => $req->get('last_name'),
            'phone' => $req->get('phone'),
            'email' => $req->get('email'),
            'password' => Hash::make($req->get('password')),
        ]);

        $token = JWTAuth::fromUser($user);

        // Trigger New User Registered Event
        event(new NewUser($user));

        return sendResponse(compact('user','token'), 201);
    }

    public function getAuthenticatedUser()
    {
        try {
            if (! $user = JWTAuth::parseToken()->authenticate()) {
                return response()->json([
                    'message' => 'User not found'
                ], 404);
            }
        } catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
            return sendResponse([
                'message' => 'Session expired please login again'
            ], $e->getStatusCode());
        } catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
            return sendResponse([
                'message' => 'Invalid token received!'
            ], $e->getStatusCode());
        } catch (Tymon\JWTAuth\Exceptions\JWTException $e) {
            return sendResponse([
                'message' => 'No token provided'
            ], $e->getStatusCode());
        }

        return sendResponse(compact('user'));
    }

    public function logout()
    {
        JWTAuth::parseToken()->invalidate();

        return sendResponse(true, 200);
    }

    public function refresh()
    {
        $token = JWTAuth::refresh();
        return sendResponse([
            'token' => $token
        ], 200);
    }

    public function verifyEmail(Request $req)
    {
        $rules = [
            'token' => 'required|exists:email_verification_token,token'
        ];

        $validator = Validator::make($req->all(), $rules);

        if($validator->fails()){
            return \sendResponse([
                'message' => $validator->errors()->first()
            ], 404);
        }

        $token = UserVerificationEmail::where('token', $req->token)->first();

        if(Carbon::parse($token->expired_at)->isPast() or $token->status){
            return \sendResponse([
                'message' => 'Verification link is expired!'
            ], 403);
        }

        $token->update([
            'confirmed' => 1
        ]);

        User::where('id', $token->user_id)->update([
            'email_verified_at' => now()->toDateTimeString()
        ]);

        return sendResponse(true);
    }

    public function forgotPassword(Request $req)
    {
        $validator = Validator::make($req->all(), [
            'email' => 'required|exists:users,email'
        ]);

        if($validator->fails()){
            return sendResponse([
                'message' => $validator->errors()->first()
            ], 400);
        }

        $user = User::where('email', $req->email)->first();

        // Trigger Reset Password Send
        event(new UserForgotPassword($user));

        return sendResponse(true, 200);
    }

    public function verifyResetPasswordToken(Request $req)
    {
        $validator = Validator::make($req->all(), [
            'token' => 'required|exists:password_resets,token'
        ]);

        if($validator->fails()){
            return sendResponse([
                'message' => $validator->errors()->first()
            ], 400);
        }

        $token = ResetPassword::where('token', $req->token)->first();

        if(Carbon::parse($token->expired_at)->isPast() or $token->status){
            return \sendResponse([
                'message' => 'Reset password link is expired!'
            ], 403);
        }

        return sendResponse(true, 200);
    }

    public function doResetPassword(Request $req)
    {
        $validator = Validator::make($req->all(), [
            'token' => 'required|exists:password_resets,token',
            'password' => 'required|string|min:8|confirmed'
        ]);

        if($validator->fails()){
            return sendResponse([
                'message' => $validator->errors()->first()
            ], 400);
        }

        $token = ResetPassword::where('token', $req->token)->first();

        if(Carbon::parse($token->expired_at)->isPast() or $token->status){
            return \sendResponse([
                'message' => 'Reset password link is expired!'
            ], 403);
        }

        try{
            $this->userUpdate($token->user_id, [
                'password' => Hash::make($req->password)
            ]);
        }catch(\Exception $e){
            return sendResponse([
                'message' => $e->getMessage()
            ], 500);
        }

        event(new UserChangePassword(User::where('id', $token->user_id)->first()));

        return sendResponse(true, 200);
    }

    public function userUpdate($userId, $toUpdate)
    {
        \DB::beginTransaction();

        try{
            $user = User::where('id', $userId);
            $oldData = $user->first();

            foreach ($toUpdate as $key => $value) {
                UserDataLogs::create([
                    'user_id' => $userId,
                    'field' => $key,
                    'old_value' => $oldData->key,
                    'new_value' => $value
                ]);
                $newData[$key] = $value;
            }
            $user->update($newData);
            \DB::commit();
            return $user->first();
        }catch(\Exception $e){
            \DB::rollback();
            \Log::error($e->getMessage());
            throw new \Exception("Failed to update user data");
        }
    }

    public function verifyToken()
    {
        $status = JWTAuth::parseToken()->check();

        if($status){
            return sendResponse($status, 200);
        }else{
            return sendResponse($status, 401);
        }
    }
}
