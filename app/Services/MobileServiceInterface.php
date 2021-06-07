<?php
/**
 * Created by PhpStorm.
 * User: AHMED HASSAN
 */

namespace App\Services;

interface MobileServiceInterface
{
    public function sendSms($to, $body);
}
