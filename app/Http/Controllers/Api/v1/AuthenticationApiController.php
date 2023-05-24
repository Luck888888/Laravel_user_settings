<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Traits\ResultTrait;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

/**
 * @OA\Info(
 *     title="User settings",
 *     version="0.1"
 * ),
 *   @OA\Server(
 *          description = "Local server",
 *          url="http://127.0.0.1:8000/api/v1"
 *      ),
 * @OA\SecurityScheme(
 *   securityScheme="bearerAuth",
 *   in="header",
 *   name="Authorization",
 *   type="http",
 *   scheme="bearer",
 *   bearerFormat="JWT",
 * ),
 */
class AuthenticationApiController
{
    use ResultTrait;
    /**
     * @OA\Post(
     *     path="/register",
     *     summary="User registration",
     *     operationId="authUser",
     *     tags={"Authentication"},
     *     requestBody={"$ref": "#/components/requestBodies/RegisterRequest"},
     *     @OA\Response(
     *         response=200,
     *         description="OK",
     *         @OA\JsonContent(
     *             @OA\Examples(example="result", value={"success": true}, summary="An result object."),
     *             @OA\Examples(example="bool", value=false, summary="A boolean value."),
     *         )
     *     )
     * )
     */
    public function store(RegisterRequest $request)
    {
        $user = User::create($request->all());

        if (!$user) {
            throw new \Exception("User profile registration failed.", 500);
        }

        $user->refresh();

        $token = $user->createToken("User token")->plainTextToken;

        return $this->sendResponse([$user,$token], __('auth.success_registered'));

    }

    /**
     * @OA\Post(
     *     path="/login",
     *     summary="User login",
     *     operationId="loginUser",
     *     tags={"Authentication"},
     *     requestBody={"$ref": "#/components/requestBodies/LoginRequest"},
     *     @OA\Response(
     *         response=200,
     *         description="OK",
     *         @OA\JsonContent(
     *             @OA\Examples(example="result", value={"success": true}, summary="An result object."),
     *             @OA\Examples(example="bool", value=false, summary="A boolean value."),
     *         )
     *     )
     * )
     */
    public function get(LoginRequest $request)
    {
        /** @var User $user */
        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return $this->sendError(__('auth.failed_login'), $errorMessages = [__('user not exist')], $code = 401);
        }

        $token = $user->createToken("User API token")->plainTextToken;

        return $this->sendResponse([$user,$token], __('auth.success_login'));
    }

    /**
     * @OA\Post(
     *     path="/logout",
     *     summary="Log out.",
     *     description="Method revokes the current access token.",
     *     operationId="logoutUser",
     *     tags={"Authentication"},
     *     security={
     *     {"bearerAuth": {}}
     *     },
     *     @OA\Response(
     *         response=200,
     *         description="OK",
     *         @OA\JsonContent(
     *             @OA\Examples(example="result", value={"success": true}, summary="An result object."),
     *             @OA\Examples(example="bool", value=false, summary="A boolean value."),
     *         )
     *     ),
     *     @OA\Response(
     *         response="401",
     *         description="Нет доступа"
     *     )
     * )
     */
    public function destroy(Request $request)
    {
        $user = optional(auth()->user())->currentAccessToken()->delete();
        return $this->sendResponse($user, __('auth.success_logout'));
    }

}
