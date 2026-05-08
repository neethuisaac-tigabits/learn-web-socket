<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'email'    => ['required', 'email'],
            'password' => ['required', 'string'],
            // Optional human-readable token name (e.g. "iPhone", "Web").
            'device'   => ['sometimes', 'string', 'max:255'],
        ];
    }
}
