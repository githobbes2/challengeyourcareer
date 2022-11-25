<?php

namespace App\Http\Requests;

use App\Models\JobOfferCandidate;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateJobOfferCandidateRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('job_offer_candidate_edit');
    }

    public function rules()
    {
        return [
            'job_offer_id' => [
                'required',
                'integer',
            ],
        ];
    }
}
