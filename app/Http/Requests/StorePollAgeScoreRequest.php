<?php

namespace App\Http\Requests;

use App\Models\PollAgeScore;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StorePollAgeScoreRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('poll_age_score_create');
    }

    public function rules()
    {
        return [
            'name' => [
                'string',
                'max:100',
                'required',
            ],
            'order' => [
                'nullable',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
            'age_start' => [
                'nullable',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
            'end_range' => [
                'nullable',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
            'professional_levels.*' => [
                'integer',
            ],
            'professional_levels' => [
                'array',
            ],
        ];
    }
}
