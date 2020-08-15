<?php

namespace App\Listeners\User;

use App\Events\UserForgotPassword;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Jobs\User\SendResetPasswordEmail as SRPE;
use App\Models\ResetPassword;

class SendResetPasswordEmail
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  UserForgotPassword  $event
     * @return void
     */
    public function handle(UserForgotPassword $event)
    {
        $user = $event->user;
        $token = str_replace('=', '', base64_encode(md5('RP'.$user->id.'('.$user->email.')-'.\strtotime(now('Asia/Jakarta')->toDateTimeString()).'-(Reset Password)')));
        $createVerificationMail = ResetPassword::create([
            'user_id' => $user->id,
            'email' => $user->email,
            'token' => $token,
            'expired_at' => now('Asia/Jakarta')->add('24 Hours')->toDateTimeString(),
            'status' => 0
        ]);

        $job = new SRPE($createVerificationMail);
        \dispatch($job);
    }
}
