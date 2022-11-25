<?php

namespace App\Http\Requests;

use App\Models\Question;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreQuestionRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('question_create');
    }

    public function rules()
    {
        return [
            'name' => [
                'string',
                'max:255',
                'required',
            ],
            'points_1' => ['numeric','min:0','max:1',],
            'points_2' => ['numeric','min:0','max:1',],
            'points_3' => ['numeric','min:0','max:1',],
            'points_4' => ['numeric','min:0','max:1',],
            'points_5' => ['numeric','min:0','max:1',],
            'session_types_1' => ['nullable','array',],
            'session_types_2' => ['nullable','array',],
            'session_types_3' => ['nullable','array',],
            'session_types_4' => ['nullable','array',],
            'session_types_5' => ['nullable','array',],
            'experience_points_1' => ['nullable','integer','min:0','max:100',],
            'experience_points_2' => ['nullable','integer','min:0','max:100',],
            'experience_points_3' => ['nullable','integer','min:0','max:100',],
            'experience_points_4' => ['nullable','integer','min:0','max:100',],
            'experience_points_5' => ['nullable','integer','min:0','max:100',],
        ];
    }
}
