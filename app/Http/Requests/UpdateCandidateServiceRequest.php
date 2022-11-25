<?php

namespace App\Http\Requests;

use App\Models\CandidateService;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateCandidateServiceRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('candidate_service_edit');
    }

    public function rules()
    {
        return [
            'candidate_id' => [
                'required',
                'integer',
            ],
            'service_item_id' => [
                'required',
                'integer',
            ],
            'date_service' => [
                'date_format:' . config('panel.date_format'),
                'nullable',
            ],
        ];
    }
}
