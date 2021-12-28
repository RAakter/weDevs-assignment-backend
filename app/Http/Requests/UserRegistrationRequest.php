<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class UserRegistrationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

        return [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$this->id.',id',
            'password' => 'required|min:8',
            'c_password' => 'required|same:password',
            'role' => 'nullable|string|exists:roles,name',
        ];

    }

    /**
     * Handle a failed validation attempt.
     *
     * @param  \Illuminate\Contracts\Validation\Validator  $validator
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        $response = response()->json([
            'success' => false,
            'errors' => $validator->errors(),
            'message' => 'Validation error',
        ], 400);

        throw (new ValidationException($validator, $response))->errorBag($this->errorBag);
    }
}
