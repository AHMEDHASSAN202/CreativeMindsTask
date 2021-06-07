<?php

namespace App\Providers;

use App\Events\RegisterUser;
use App\Events\ResendVerifyCodeEvent;
use App\Events\UpdatePhoneWhenUpdatedProfile;
use App\Events\UserAttemptedToLogin;
use App\Events\UserNotVerifiedMobileWhenLogin;
use App\Events\UserSuccessLogin;
use App\Listeners\RefreshVerifyCodeListener;
use App\Listeners\SendSmsVerifyCodeListener;
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
        UserAttemptedToLogin::class => [

        ],
        UserNotVerifiedMobileWhenLogin::class => [
            RefreshVerifyCodeListener::class,
            SendSmsVerifyCodeListener::class
        ],
        UserSuccessLogin::class => [

        ],
        RegisterUser::class => [
            RefreshVerifyCodeListener::class,
            SendSmsVerifyCodeListener::class
        ],
        ResendVerifyCodeEvent::class => [
            RefreshVerifyCodeListener::class,
            SendSmsVerifyCodeListener::class
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
