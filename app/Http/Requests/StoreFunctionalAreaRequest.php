<?php

namespace App\Http\Requests;

use App\Models\FunctionalArea;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreFunctionalAreaRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('functional_area_create');
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
