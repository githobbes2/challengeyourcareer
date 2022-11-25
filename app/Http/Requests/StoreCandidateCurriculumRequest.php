<?php

namespace App\Http\Requests;

use App\Models\CandidateCurriculum;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreCandidateCurriculumRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('candidate_curriculum_create');
    }

    public function rules()
    {
        return [
            'candidate_id' => [
                'required',
                'integer',
            ],
            'name' => [
                'string',
                'max:100',
                'required',
            ],
        ];
    }
}
