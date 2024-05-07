<?php

namespace App\Http\Requests;

use App\Libs\ConfigUtil;
use App\Rules\{CheckMailRFC, CheckMaxLength, CheckNotNull, CheckOnlyNumberAndAlphabetOneByte};
use Illuminate\Foundation\Http\FormRequest;

class EditUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array {
        $id = $this->id ?? -1;
        return [
            'name' => [
                'required',
                new CheckMaxLength('Name', 100),
            ],
            'email' => [
                'required',
                new CheckMailRFC(),
                'unique:user,email,' . $id,
                new CheckMaxLength('Email', 255),
            ],
            'group_id' => [
                'required',
                new CheckNotNull(),
                new CheckOnlyNumberAndAlphabetOneByte(),
            ],
            'started_date' => [
                'required',
                'date_format:d/m/Y',
            ],
            'position_id' => [
                'required',
                new CheckNotNull(),
                new CheckOnlyNumberAndAlphabetOneByte(),
            ],
            'password' => $this->isPasswordUpdateRequested() ? [
                'required',
                'regex:/^(?=.*[0-9])(?=.*[a-zA-Z])[0-9a-zA-z]+$/',
                new CheckMaxLength('Password', 20),
                'between:8,20',
            ] : '',
            'repassword' => $this->isPasswordUpdateRequested() ? [
                'required',
                new CheckMaxLength('Password Confirmation', 20),
                'same:password',
            ] : '',
        ];
    }

    public function messages() {
        return [
            'name.required' => ConfigUtil::getMessage('EBT001', [':attribute']),

            'email.required' => ConfigUtil::getMessage('EBT001', [':attribute']),
            'email.unique' => ConfigUtil::getMessage('EBT019'),

            'group_id.required' => ConfigUtil::getMessage('EBT001', [':attribute']),

            'started_date.required' => ConfigUtil::getMessage('EBT001', [':attribute']),
            'started_date.date_format' => ConfigUtil::getMessage('EBT008', [':attribute']),

            'position_id.required' => ConfigUtil::getMessage('EBT001', [':attribute']),

            'password.required' => ConfigUtil::getMessage('EBT001', [':attribute']),
            'password.regex' => ConfigUtil::getMessage('EBT025', [':attribute']),
            'password.between' => ConfigUtil::getMessage('EBT023'),

            'repassword.required' => ConfigUtil::getMessage('EBT001', [':attribute']),
            'repassword.same' => ConfigUtil::getMessage('EBT030'),
        ];
    }

    public function attributes() {
        return [
            'name' => 'User Name',
            'email' => 'Email',
            'group_id' => 'Group',
            'started_date' => 'Started Date',
            'position_id' => 'Position',
            'password' => 'Password',
            'repassword' => 'Password Confirmation',
        ];
    }

    private function isPasswordUpdateRequested(): bool {
        return $this->filled('password');
    }
}
