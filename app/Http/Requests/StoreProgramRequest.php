<?php

namespace App\Http\Requests;

use App\Models\Program;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreProgramRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('program_create');
    }

    public function rules()
    {
        return [
            'name' => [
                'string',
                'max:255',
                'required',
            ],
            'internal_name' => [
                'string',
                'max:255',
                'nullable',
            ],
            'individual' => [
                'required',
            ],
            'invoice' => [
                'string',
                'max:255',
                'nullable',
            ],
            'reference' => [
                'string',
                'max:255',
                'nullable',
            ],
        ];
    }
}
