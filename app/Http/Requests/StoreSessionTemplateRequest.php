<?php

namespace App\Http\Requests;

use App\Models\SessionTemplate;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreSessionTemplateRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('session_template_create');
    }

    public function rules()
    {
        return [
            'title' => [
                'string',
                'max:255',
                'required',
            ]
        ];
    }
}
