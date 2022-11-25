<?php

namespace App\Http\Requests;

use App\Models\CandidateProgram;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateCandidateProgramRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('candidate_program_edit');
    }

    public function rules()
    {
        return [
            'tags.*' => [
                'integer',
            ],
            'tags' => [
                'array',
            ],
            'program_start_date' => [
                'date_format:' . config('panel.date_format'),
                'nullable',
            ],
            'program_end_date' => [
                'date_format:' . config('panel.date_format'),
                'nullable',
            ],
            'relocation_date' => [
                'date_format:' . config('panel.date_format'),
                'nullable',
            ],
        ];
    }
}
