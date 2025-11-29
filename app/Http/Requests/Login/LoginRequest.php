<?php

namespace App\Http\Requests\Login;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    public function rules()
    {
        return [
            'email' => ['required','email'],
            'password' => ['required'],
            'ga_code' => ['nullable','digits:6']
        ];
    }
}

