<?php

namespace App\Http\Requests;

use App\Models\EducationLevel;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreEducationLevelRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('education_level_create');
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
