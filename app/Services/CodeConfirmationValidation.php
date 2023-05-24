<?php

namespace App\Services;

use App\Interfaces\ConfirmationValidationInterface;
use App\Models\UserSetting;

class CodeConfirmationValidation implements ConfirmationValidationInterface
{
    public function validateConfirmation(UserSetting $userSetting, string $code, string $method): bool
    {
        $confirmation = $userSetting->confirmations()
                      ->where('code', $code)
                      ->where('method', $method)->first();
        return (bool) $confirmation;
    }
}
