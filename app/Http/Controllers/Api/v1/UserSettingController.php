<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\ConfirmUserSettingRequest;
use App\Http\Requests\UpdateUserSettingRequest;
use App\Models\UserSetting;
use App\Services\UserSettingsService;
use Exception;
use Illuminate\Support\Facades\Log;

class UserSettingController extends Controller
{
    /**
     * @OA\Post(
     *     path="/user-settings/{userSetting}",
     *     summary="Update user setting",
     *     description="Update a user setting and send a confirmation code via the specified method.",
     *     tags={"User Settings"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="userSetting",
     *         in="path",
     *         description="ID of the user setting",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *  requestBody={"$ref": "#/components/requestBodies/UpdateUserSettingRequest"},
     *     @OA\Response(
     *         response="200",
     *         description="Confirmation code sent"
     *     ),
     *     @OA\Response(
     *         response="400",
     *         description="Invalid input"
     *     ),
     *     @OA\Response(
     *         response="404",
     *         description="User setting not found"
     *     ),
     *     @OA\Response(
     *         response="500",
     *         description="Internal server error"
     *     )
     * )
     */
    public function sent(UpdateUserSettingRequest $request, UserSetting $userSetting,UserSettingsService $service)
    {
        $method = $request->input('method');
        if (!$userSetting->exists()) {
            return response()->json(['message' => 'User setting not found'], 404);
        }
        $service->updateSetting($userSetting, $method);

        return response()->json(['message' => 'Confirmation code sent']);
    }


    /**
     * @OA\Post(
     *     path="/settings/{setting}/confirm",
     *     summary="Confirm user setting",
     *     description="Confirm user setting by code and method",
     *     tags={"User Settings"},
     *     security={{"bearerAuth": {}}},
     *    @OA\Parameter(
     *         name="setting",
     *         in="path",
     *         description="setting ID",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *   requestBody={"$ref": "#/components/requestBodies/ConfirmUserSettingRequest"},
     *     @OA\Response(
     *         response=200,
     *         description="Setting confirmed",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="Setting confirmed"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid confirmation code or method",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="Invalid confirmation code or method"
     *             )
     *         )
     *     )
     * )
     */
    public function confirm(ConfirmUserSettingRequest $request, $settingId, UserSettingsService $service)
    {
        try {
            $code = $request->input('code');
            $method = $request->input('method');
            $value = $request->input('value');

            $userSetting = UserSetting::where('user_id', auth()->user()->id)
                                       ->where('id', $settingId)
                                       ->firstOrFail();

            $service->confirmSetting($userSetting, $code, $method, $value);

            return response()->json(['message' => 'Setting confirmed']);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['message' => $e->getMessage()], 400);
        }
    }

}
