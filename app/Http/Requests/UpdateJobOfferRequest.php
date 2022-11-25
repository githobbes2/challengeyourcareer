<?php

namespace App\Http\Requests;

use App\Models\JobOffer;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateJobOfferRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('job_offer_edit');
    }

    public function rules()
    {
        return [
            'title' => [
                'string',
                'max:255',
                'required',
            ],
            'active' => [
                'required',
            ],
            'date_start' => [
                'required',
                'date_format:' . config('panel.date_format'),
            ],
            'date_end' => [
                'date_format:' . config('panel.date_format'),
                'nullable',
            ],
            'tags.*' => [
                'integer',
            ],
            'tags' => [
                'array',
            ],
            'company' => [
                'string',
                'max:255',
                'nullable',
            ],
            'contact_name' => [
                'string',
                'max:255',
                'nullable',
            ],
            'contact_phone' => [
                'string',
                'max:255',
                'nullable',
            ],
            'url' => [
                'string',
                'max:500',
                'nullable',
            ],
            'languages.*' => [
                'integer',
            ],
            'languages' => [
                'array',
            ],
            'attachments' => [
                'array',
            ],
        ];
    }
}
