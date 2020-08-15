<?php

namespace App\Listeners\NewUser;

use App\Events\NewUser;
use App\Models\UserVerificationEmail as UVE;
use App\Jobs\User\SendVerificationEmail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendVerificationMail
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
     * @param  NewUser  $event
     * @return void
     */
    public function handle(NewUser $event)
    {
        $user = $event->user;
        $vericationToken = str_replace('=', '', base64_encode(md5($user->id.'('.$user->email.')-'.\strtotime(now('Asia/Jakarta')->toDateTimeString()))));
        $createVerificationMail = UVE::create([
            'user_id' => $user->id,
            'email' => $user->email,
            'token' => $vericationToken,
            'expired_at' => now('Asia/Jakarta')->add('24 Hours')->toDateTimeString(),
            'confirmed' => 0
        ]);

        $job = new SendVerificationEmail($createVerificationMail);
        \dispatch($job);
    }
}
