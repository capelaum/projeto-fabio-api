<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class ResetPasswordRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            "token" => "required|string",
            "email" => "required|string|email|max:255|exists:users",
            "password" => [
                "required",
                "string",
                "min:8",
                "max:255",
                "regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*(_|[^\w])).+$/"
            ],
            "confirmPassword" => "required|string|min:8|max:255",
        ];
    }
}
