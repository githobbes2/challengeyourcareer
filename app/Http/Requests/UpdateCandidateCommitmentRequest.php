<?php

namespace App\Http\Requests;

use App\Models\CandidateCommitment;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateCandidateCommitmentRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('candidate_commitment_edit');
    }

    public function rules()
    {
        return [
            'title' => [
                'string',
                'max:255',
                'required',
            ],
            'candidate_id' => [
                'integer',
            ],
            'completion_date' => [
                'date_format:' . config('panel.date_format'),
                'nullable',
            ],
            'tags.*' => [
                'integer',
            ],
            'tags' => [
                'array',
            ],
            'development_area_id' => [
                'required',
            ],
            'experience_points' => [
                'nullable',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
        ];
    }
}
