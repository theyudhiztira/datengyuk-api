<?php

namespace App\Listeners\User;

use App\Events\UserChangePassword;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

//Models
use App\Models\ResetPassword;


class RemoveResetPasswordToken
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
     * @param  UserChangePassword  $event
     * @return void
     */
    public function handle(UserChangePassword $event)
    {
        ResetPassword::where('user_id', $event->payload->id)
        ->where('status', 0)
        ->update([
            'status' => 1
        ]);

        return true;
    }
}
