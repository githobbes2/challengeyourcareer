<?php

namespace App\Http\Requests;

use App\Models\Candidate;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateCandidateRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('candidate_edit');
    }

    public function rules()
    {
        return [
            'name' => [
                'string',
                'max:255',
                'required',
            ],
            'lastname' => [
                'string',
                'max:255',
                'nullable',
            ],
            'email' => [
                'required',
            ],
            'phone' => [
                'string',
                'max:255',
                'nullable',
            ],
            'birthday' => [
                'date_format:' . config('panel.date_format'),
                'nullable',
            ],
            'government_number' => [
                'string',
                'max:255',
                'nullable',
            ],
            'passport' => [
                'string',
                'max:255',
                'nullable',
            ],
            'languages.*' => [
                'integer',
            ],
            'languages' => [
                'array',
            ],
            'social_linkedin' => [
                'string',
                'max:255',
                'nullable',
            ],
            'company_id' => [
                'required',
                'integer',
            ],
            'address' => [
                'string',
                'max:500',
                'nullable',
            ],
            'postalcode' => [
                'string',
                'max:50',
                'nullable',
            ],
            'tags.*' => [
                'integer',
            ],
            'tags' => [
                'array',
            ],
            'skills.*' => [
                'integer',
            ],
            'skills' => [
                'array',
            ],
            'position' => [
                'string',
                'max:255',
                'nullable',
            ],
            'related_companies.*' => [
                'integer',
            ],
            'related_companies' => [
                'array',
            ],
            'employability_score' => [
                'numeric',
            ],
            'employability_score_date' => [
                'date_format:' . config('panel.date_format'),
                'nullable',
            ],
        ];
    }
}
