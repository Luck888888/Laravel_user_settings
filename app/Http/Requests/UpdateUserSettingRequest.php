<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserSettingRequest extends FormRequest
{
    /**
     * @OA\RequestBody(
     *     request="UpdateUserSettingRequest", required=true,
     *     description="Update user settings.",
     *     @OA\MediaType(
     *         mediaType="application/x-www-form-urlencoded",
     *         @OA\Schema(
     *              type="object",
     *             @OA\Property(
     *                  property="method", type="string",default="email",enum={"email","sms","telegram"},
     *                  description="The method."
     *              ),
     *              required={"method"}
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
            'method' => 'required|string',
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
