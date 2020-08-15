<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/', function () {
    return sendReponse([
        'message' => 'Hello there!'
    ], 200);
});

Route::post('login', 'User\UserController@login');
Route::post('register', 'User\UserController@register');
Route::group(['middleware' => 'jwt.verify'], function () {
    Route::post('verify-token', 'User\UserController@verifyToken');
    Route::post('logout', 'User\UserController@logout');
    Route::post('refresh', 'User\UserController@refresh');
    Route::post('detail', 'User\UserController@getAuthenticatedUser');
});

Route::post('verify-email', 'User\UserController@verifyEmail');
Route::post('forgot-password', 'User\UserController@forgotPassword');
Route::post('verify-reset-token', 'User\UserController@verifyResetPasswordToken');
Route::post('reset-password', 'User\UserController@doResetPassword');

Route::any('{all}', function () {
    return response()->json([
        'message' => 'resource not found!'
    ], 404);
})->where('all', '.*');
