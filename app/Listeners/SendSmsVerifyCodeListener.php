<?php

namespace App\Listeners;

use App\Services\TwilioMobileService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class SendSmsVerifyCodeListener
{
    public function handle($event)
    {
        //load verifyCode relation if not load
        $event->user->loadMissing('verifyCode');
        //prepare mobile number
        $mobileNumber = '+' . (string)$event->user->mobile;
        //message body
        $body = sprintf('Your verification code is: %d', $event->user->verifyCode->verify_code);

        try {
            $twilioMobileService = new TwilioMobileService();
            $twilioMobileService->sendSms($mobileNumber, $body);
        }catch (\Exception $exception) {
            Log::error('SendSmsVerifyCodeListener >>' . $exception->getMessage());
        }
    }
}
