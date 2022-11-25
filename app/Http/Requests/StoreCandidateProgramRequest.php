<?php

namespace App\Http\Requests;

use App\Models\CandidateProgram;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreCandidateProgramRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('candidate_program_create');
    }

    public function rules()
    {
        return [
            'program_id' => [
                'required',
                'integer',
            ],
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
