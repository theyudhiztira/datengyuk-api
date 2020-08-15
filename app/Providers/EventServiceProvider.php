<?php

namespace App\Providers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'App\Events\NewUser' => [
            'App\Listeners\NewUser\SendVerificationMail'
        ],
        'App\Events\UserForgotPassword' => [
            'App\Listeners\User\SendResetPasswordEmail'
        ],
        'App\Events\UserChangePassword' => [
            'App\Listeners\User\RemoveResetPasswordToken',
            'App\Listeners\User\NotifyPasswordChange'
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
