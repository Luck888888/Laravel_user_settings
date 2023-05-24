<?php

namespace App\Services;

use App\Models\UserSetting;
use Exception;
use Illuminate\Support\Str;

class UserSettingsService
{
    private  $confirmationService;
    private  $validator;

    public function __construct(
        ConfirmationServiceFactory $confirmationService,
        CodeConfirmationValidation $validator
    ) {
        $this->confirmationService = $confirmationService;
        $this->validator = $validator;
    }

    /**
     * @throws Exception
     */
    public function updateSetting(UserSetting $userSetting, $method)
    {
        $code = Str::random(6);
        $confirmationService = $this->confirmationService->createService($method);

        $confirmation = $userSetting->confirmations()->create([
            'code'   => $code,
            'method' => $method,
        ]);
        $confirmationService->sendConfirmation($userSetting, $method, $code);
    }

    public function confirmSetting(UserSetting $userSetting, $code, $method, $value)
    {
        if (!$this->validator->validateConfirmation($userSetting, $code, $method)) {
            throw new Exception('Invalid confirmation code or method');
        }

        $userSetting->update(['value' => $value]);

        if (!$userSetting->confirmations()->where('code', $code)->delete()) {
            throw new Exception('Error deleting confirmation');
        }
    }

}
