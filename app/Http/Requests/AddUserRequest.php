<?php

namespace App\Http\Requests;

use App\Libs\ConfigUtil;
use App\Rules\{CheckMailRFC, CheckMaxLength, CheckNotNull, CheckOnlyNumberAndAlphabetOneByte};
use Illuminate\Foundation\Http\FormRequest;

class AddUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool {
        return true;
    }

    public function getLenghtOfValueByAttributeName(string $attributeName)
    {
        $attribute = $this->get($attributeName);

        return strlen($attribute);
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
                'max:100',
            ],
            'email' => [
                'required',
                new CheckMailRFC(),
                'unique:user,email,'.$id,
                'max:255',
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
            'password' => [
                'required',
                'regex:/^(?=.*[0-9])(?=.*[a-zA-Z])[0-9a-zA-z]+$/',
                'max:20',
                'between:8,20',
            ],
            'repassword' => [
                'required',
                'max:20',
                'same:password',
            ],
        ];
    }

    public function messages()
    {
        return [
            'name.required' => ConfigUtil::getMessage('EBT001', [':attribute']),
            'name.max' => ConfigUtil::getMessage('EBT002', [
                ':attribute',
                ':max',
                $this->getLenghtOfValueByAttributeName('name'),
            ]),
            'email.required' => ConfigUtil::getMessage('EBT001', [':attribute']),
            'email.unique' => ConfigUtil::getMessage('EBT019'),
            'email.max' => ConfigUtil::getMessage('EBT002', [
                ':attribute',
                ':max',
                $this->getLenghtOfValueByAttributeName('email'),
            ]),
            'group_id.required' => ConfigUtil::getMessage('EBT001', [':attribute']),

            'started_date.required' => ConfigUtil::getMessage('EBT001', [':attribute']),
            'started_date.date_format' => ConfigUtil::getMessage('EBT008', [':attribute']),

            'position_id.required' => ConfigUtil::getMessage('EBT001', [':attribute']),

            'password.required' => ConfigUtil::getMessage('EBT001', [':attribute']),
            'password.regex' => ConfigUtil::getMessage('EBT025', [':attribute']),
            'password.between' => ConfigUtil::getMessage('EBT023'),
            'password.max' => ConfigUtil::getMessage('EBT002', [
                ':attribute',
                ':max',
                $this->getLenghtOfValueByAttributeName('password'),
            ]),
            
            'repassword.required' => ConfigUtil::getMessage('EBT001', [':attribute']),
            'repassword.same' => ConfigUtil::getMessage('EBT030'),
            'repassword.max' => ConfigUtil::getMessage('EBT002', [
                ':attribute',
                ':max',
                $this->getLenghtOfValueByAttributeName('repassword'),
            ]),
        ];
    }


    public function attributes()
    {
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
}
