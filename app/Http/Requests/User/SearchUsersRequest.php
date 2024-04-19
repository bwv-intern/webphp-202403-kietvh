<?php

namespace App\Http\Requests\User;

use App\Libs\ConfigUtil;
use App\Rules\{CheckGreatherThanDate, CheckLessThanDate, CheckMaxLength};
use Illuminate\Foundation\Http\FormRequest;

class SearchUsersRequest extends FormRequest
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
        $startedDateFrom = $this->input('started_date_from');
        $startedDateTo = $this->input('started_date_to');
        return [
            'name' => [
                new CheckMaxLength('User Name', 20),
            ],
            'started_date_from' => ['nullable',
                'date_format:d/m/Y',
                new CheckGreatherThanDate('Started Date From', 'Started Date To', $startedDateTo ?? "", 'd/m/Y'),
                new CheckLessThanDate('Started Date From', 'Started Date To', $startedDateFrom ?? "", 'd/m/Y'),
            ],
            'started_date_to' => ['nullable',
                                  'date_format:d/m/Y',
                                 ],
        ];
    }

    public function messages() {
        return [
            'started_date_from.date_format' => ConfigUtil::getMessage('EBT008',['Started Date From']),
            'started_date_to.date_format' => ConfigUtil::getMessage('EBT008',['Started Date To']),
        ];
    }
}
