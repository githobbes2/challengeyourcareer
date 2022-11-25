<?php

namespace App\Http\Requests;

use App\Models\Consultant;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreConsultantRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('consultant_create');
    }

    public function rules()
    {
        return [
            'user_id' => [
                'required',
                'integer',
            ],
            'consultant_type_id' => [
                'required',
                'integer',
            ],
            'skill_tags.*' => [
                'integer',
            ],
            'skill_tags' => [
                'array',
            ],
            'url_linkedin' => [
                'string',
                'nullable',
            ],
        ];
    }
}
