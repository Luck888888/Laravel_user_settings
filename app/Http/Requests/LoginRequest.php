<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    /**
     * @OA\RequestBody(
     *     request="LoginRequest", required=true,
     *     description="Login users.",
     *     @OA\MediaType(
     *         mediaType="application/x-www-form-urlencoded",
     *         @OA\Schema(
     *              type="object",
     *              @OA\Property(
     *                  property="email", type="string", format="email", example="user@email.com",
     *                  description="The user email."
     *              ),
     *             @OA\Property(
     *                  property="password", type="string", example="UserPassword",
     *                  description="The user password."
     *              ),
     *              required={"email","password"}
     *         )
     *     )
     * )
     *
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email'    => 'required|string',
            'password' => 'required|string',
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}
