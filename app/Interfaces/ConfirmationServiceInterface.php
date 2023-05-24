<?php

namespace App\Interfaces;

use App\Models\UserSetting;

interface ConfirmationServiceInterface
{
    public function sendConfirmation(UserSetting $userSetting, $method, $code);

}
