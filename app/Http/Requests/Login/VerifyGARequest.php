<?php

namespace App\Http\Requests\Login;

use Illuminate\Foundation\Http\FormRequest;

class VerifyGARequest extends FormRequest
{
    public function rules()
    {
        return [
            'email' => ['required','email'],
            'code' => ['required','digits:6']
        ];
    }
}

