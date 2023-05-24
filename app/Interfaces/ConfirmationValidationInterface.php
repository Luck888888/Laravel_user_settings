<?php

namespace App\Interfaces;
use App\Models\UserSetting;

interface ConfirmationValidationInterface
{
    public function validateConfirmation(UserSetting $userSetting, string $code, string $method): bool;

}
