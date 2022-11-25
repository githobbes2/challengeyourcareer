<?php

namespace App\Http\Requests;

use App\Models\ProgramType;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreProgramTypeRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('program_type_create');
    }

    public function rules()
    {
        return [
            'name' => [
                'string',
                'max:255',
                'required',
            ],
            'description' => [
                'string',
                'max:500',
                'nullable',
            ],
            'service_groups.*' => [
                'integer',
            ],
            'service_groups' => [
                'array',
            ],
            'session_types.*' => [
                'integer',
            ],
            'session_types' => [
                'array',
            ],
        ];
    }
}
