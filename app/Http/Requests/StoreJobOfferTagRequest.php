<?php

namespace App\Http\Requests;

use App\Models\JobOfferTag;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreJobOfferTagRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('job_offer_tag_create');
    }

    public function rules()
    {
        return [
            'name' => [
                'string',
                'max:255',
                'required',
            ],
        ];
    }
}
