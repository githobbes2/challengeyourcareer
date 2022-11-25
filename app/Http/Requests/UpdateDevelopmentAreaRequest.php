<?php

namespace App\Http\Requests;

use App\Models\DevelopmentArea;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateDevelopmentAreaRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('development_area_edit');
    }

    public function rules()
    {
        return [
            'name' => [
                'string',
                'max:100',
                'required',
            ],
        ];
    }
}
