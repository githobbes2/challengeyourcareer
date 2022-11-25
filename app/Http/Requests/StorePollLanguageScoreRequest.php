<?php

namespace App\Http\Requests;

use App\Models\PollLanguageScore;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StorePollLanguageScoreRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('poll_language_score_create');
    }

    public function rules()
    {
        return [
            'language_id' => [
                'required',
                'integer',
            ],
            'education_level_id' => [
                'required',
                'integer',
            ],
            'points' => [
                'numeric',
                'required',
                'min:0',
                'max:1',
            ],
        ];
    }
}
