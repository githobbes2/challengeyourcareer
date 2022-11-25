<?php

namespace App\Http\Requests;

use App\Models\RecruiterType;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateRecruiterTypeRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('recruiter_type_edit');
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
