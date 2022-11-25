<?php

namespace App\Http\Requests;

use App\Models\Poll;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StorePollRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('poll_create');
    }

    public function rules()
    {
        return [
            'name' => [
                'string',
                'max:100',
                'required',
            ],
            'question_groups.*' => [
                'integer',
            ],
            'question_groups' => [
                'array',
            ],
            'label_1' => [
                'string',
                'max:50',
                'nullable',
            ],
            'label_2' => [
                'string',
                'max:50',
                'nullable',
            ],
            'label_3' => [
                'string',
                'max:50',
                'nullable',
            ],
            'label_4' => [
                'string',
                'max:50',
                'nullable',
            ],
            'label_5' => [
                'string',
                'max:50',
                'nullable',
            ],
        ];
    }
}
