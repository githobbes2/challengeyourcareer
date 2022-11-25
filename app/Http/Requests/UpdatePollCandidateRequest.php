<?php

namespace App\Http\Requests;

use App\Models\PollCandidate;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdatePollCandidateRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('poll_candidate_edit');
    }

    public function rules()
    {
        return [
            'poll_id' => [
                'required',
                'integer',
            ],
            'candidate_id' => [
                'required',
                'integer',
            ],
            'score' => [
                'numeric',
            ],
            'experience_points' => [
                'nullable',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
            'age' => [
                'nullable',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
            'company' => [
                'string',
                'max:100',
                'nullable',
            ],
            'languages.*' => [
                'integer',
            ],
            'languages' => [
                'array',
            ],
        ];
    }
}
