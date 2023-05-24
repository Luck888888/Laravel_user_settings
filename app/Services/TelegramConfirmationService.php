<?php

namespace App\Services;

use App\Interfaces\ConfirmationServiceInterface;
use App\Models\UserSetting;

class TelegramConfirmationService implements ConfirmationServiceInterface
{
    public function sendConfirmation(UserSetting $userSetting, $method, $code)
    {
        // Send Telegram confirmation code
    }
}
