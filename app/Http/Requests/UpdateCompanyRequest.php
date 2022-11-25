<?php

namespace App\Http\Requests;

use App\Models\Company;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateCompanyRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('company_edit');
    }

    public function rules()
    {
        return [
            'name' => [
                'string',
                'max:255',
                'required',
            ],
            'tax_number' => [
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
            'countries.*' => [
                'integer',
            ],
            'countries' => [
                'array',
            ],
            'attachments' => [
                'array',
            ],
        ];
    }
}
