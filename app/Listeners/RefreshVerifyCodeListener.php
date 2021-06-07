<?php

namespace App\Listeners;

use App\Models\VerifyCode;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class RefreshVerifyCodeListener
{
    public function handle($event)
    {
        //we will update or insert verification code
        //set new verify_code
        //set new expired_at
        VerifyCode::updateOrInsert(
            ['user_id' => $event->user->id],
            ['verify_code' => generateVerifyCode(), 'expired_at' => now()->addMinutes(30)]
        );
    }
}
