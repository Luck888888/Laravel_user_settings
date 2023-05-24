<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ConfirmUserSettingRequest extends FormRequest
{
    /**
     * @OA\RequestBody(
     *     request="ConfirmUserSettingRequest", required=true,
     *     description="Confirm user settings.",
     *     @OA\MediaType(
     *         mediaType="application/x-www-form-urlencoded",
     *         @OA\Schema(
     *              type="object",
     *              @OA\Property(
     *                  property="code", type="string", example="confCode",
     *                  description="Confirmation code."
     *              ),
     *              @OA\Property(
     *                  property="method", type="string", example="confMethod",
     *                  description="Confirmation method."
     *              ),
     *       @OA\Property(
     *                  property="value", type="string", example="value",
     *                  description="new value."
     *              ),
     *              required={"code","method","value"}
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
            'code'   => 'required|string',
            'method' => 'required|string',
            'value'  => 'required|string',
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
