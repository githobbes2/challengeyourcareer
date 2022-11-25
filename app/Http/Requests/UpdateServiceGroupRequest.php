<?php

namespace App\Http\Requests;

use App\Models\ServiceGroup;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateServiceGroupRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('service_group_edit');
    }

    public function rules()
    {
        return [
            'type' => [
                'required',
            ],
            'name' => [
                'string',
                'max:100',
                'required',
            ],
            'service_items.*' => [
                'integer',
            ],
            'service_items' => [
                'array',
            ],
        ];
    }
}
