<?php

namespace App\Http\Requests;

use App\Models\Candidate;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreCandidateRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('candidate_create');
    }

    public function rules()
    {
        return [
            'email' => [
                'required',
                'unique:users',
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
