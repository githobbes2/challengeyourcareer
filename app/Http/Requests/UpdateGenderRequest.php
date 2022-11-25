<?php

namespace App\Http\Requests;

use App\Models\Gender;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateGenderRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('gender_edit');
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
