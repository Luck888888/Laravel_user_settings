<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{

    /**
     * @OA\RequestBody(
     *     request="RegisterRequest", required=true,
     *     description="Register users.",
     *     @OA\MediaType(
     *         mediaType="application/x-www-form-urlencoded",
     *         @OA\Schema(
     *              type="object",
     *              @OA\Property(
     *                  property="name", type="string", example="UserName",
     *                  description="The user name."
     *              ),
     *              @OA\Property(
     *                  property="email", type="string", example="UserEmail",
     *                  description="The user email."
     *              ),
     *             @OA\Property(
     *                  property="password", type="string", example="UserPassword",
     *                  format="password",
     *                  description="The user password."
     *              ),
     *              required={"name","email","password"}
     *         )
     *     )
     * )
     *
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'name'     => 'required|string',
            'email'    => 'required|string|email|unique:users,email',
            'password' => 'required|string',
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

}
