<?php

namespace App\Http\Requests;

use App\Models\EventCandidate;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreEventCandidateRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('event_candidate_create');
    }

    public function rules()
    {
        return [
            'event_id' => [
                'required',
                'integer',
            ],
            'candidate_id' => [
                'required',
                'integer',
            ],
        ];
    }
}
