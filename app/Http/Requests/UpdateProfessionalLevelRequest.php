<?php

namespace App\Http\Requests;

use App\Models\ProfessionalLevel;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateProfessionalLevelRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('professional_level_edit');
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
