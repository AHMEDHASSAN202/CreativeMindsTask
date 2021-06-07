<?php
/**
 * Created by PhpStorm.
 * User: AHMED HASSAN
 */

namespace App\Services;
use Twilio\Rest\Client;

class TwilioMobileService implements MobileServiceInterface
{
    private $client;

    public function __construct()
    {
        $this->client = new Client(env('TWILIO_SID', 'ACd757fee006efe36521832947217b1065'), env('TWILIO_TOKEN', '541a67c586c4cdb0750a5067d63d47f4'));
    }

    public function sendSms($to, $body)
    {
        $this->client->messages->create($to, ['body' => $body, 'messagingServiceSid' => env('TWILIO_MESSAGING_SERVICE_SID', 'MGa71027e2167391d372bd32955168c164')]);
    }
}
