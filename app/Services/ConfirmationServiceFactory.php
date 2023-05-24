<?php

namespace App\Services;

use App\Interfaces\ConfirmationServiceInterface;
use Exception;

class ConfirmationServiceFactory
{
    public function createService(string $method): ConfirmationServiceInterface
    {
        switch ($method) {
            case 'sms':
                return new SmsConfirmationService();
            case 'email':
                return new EmailConfirmationService();
            case 'telegram':
                return new TelegramConfirmationService();
            default:
                throw new Exception('Invalid confirmation method');
        }
    }

}
