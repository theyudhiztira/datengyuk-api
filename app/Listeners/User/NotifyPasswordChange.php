<?php

namespace App\Listeners\User;

use App\Events\UserChangePassword;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Jobs\User\NotifyPasswordChange as NotifyJob;

class NotifyPasswordChange
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
        $job = new NotifyJob($event->payload);
        dispatch($job);
    }
}
