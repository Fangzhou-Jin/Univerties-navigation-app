<?php

namespace App\Http\Requests\Login;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    public function rules()
    {
        return [
            'email' => ['required','email','unique:users,email'],
            'password' => ['required','min:6']
        ];
    }
}
