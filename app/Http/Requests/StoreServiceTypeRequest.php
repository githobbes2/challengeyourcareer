<?php

namespace App\Http\Requests;

use App\Models\ServiceType;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreServiceTypeRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('service_type_create');
    }

    public function rules()
    {
        return [
            'code' => [
                'string',
                'max:5',
                'required',
            ],
            'name' => [
                'string',
                'max:100',
                'required',
            ],
            'type' => [
                'required',
            ],
        ];
    }
}
