<?php

namespace App\Services;

use App\Interfaces\ConfirmationServiceInterface;
use App\Models\UserSetting;

class SmsConfirmationService implements ConfirmationServiceInterface
{

    public function sendConfirmation(UserSetting $userSetting, $method, $code)
    {
        // Send SMS confirmation code Twilio

    }
}
