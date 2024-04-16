<?php

namespace App\Http\Requests\Auth;

use App\Libs\ConfigUtil;
use App\Rules\{CheckEmail, CheckMaxLength};
use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {
        return [
            'email' => [
                'required',
                new CheckEmail(),
                new CheckMaxLength('Email', 255),
            ],
            'password' => [
                'required',
                new CheckMaxLength('Password', 20),
            ],
        ];
    }

    /**
     * Validation error message
     *
     * @return array
     */
    public function messages() {
        return [
            'email.required' => ConfigUtil::getMessage('EBT001', 'Email'),
            'password.required' => ConfigUtil::getMessage('EBT001', 'Password'),
        ];
    }
}
