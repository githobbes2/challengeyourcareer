<?php

namespace App\Http\Requests;

use App\Models\QuestionGroup;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateQuestionGroupRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('question_group_edit');
    }

    public function rules()
    {
        return [
            'name' => [
                'string',
                'max:255',
                'required',
            ],
            'order' => [
                'nullable',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
            'weight' => [
                'nullable',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
            'questions.*' => [
                'integer',
            ],
            'questions' => [
                'array',
            ],
        ];
    }
}
