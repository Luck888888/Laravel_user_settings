<?php

namespace App\Services;

use App\Interfaces\ConfirmationServiceInterface;
use App\Mail\ConfirmationEmail;
use App\Models\UserSetting;
use Illuminate\Support\Facades\Mail;

class EmailConfirmationService implements ConfirmationServiceInterface
{
    public function sendConfirmation(UserSetting $userSetting, $method, $code)
    {
        $email = $userSetting->user->email;
        $subject = 'Confirmation code';
        $data = [
            'code' => $code,
        ];
        Mail::to($email)->send(new ConfirmationEmail($subject, $data));
    }
}
