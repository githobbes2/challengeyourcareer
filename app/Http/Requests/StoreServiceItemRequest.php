<?php

namespace App\Http\Requests;

use App\Models\ServiceItem;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreServiceItemRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('service_item_create');
    }

    public function rules()
    {
        return [
            'type' => [
                'required',
            ],
            'service_type_id' => [
                'required',
                'integer',
            ],
            'name' => [
                'string',
                'max:255',
                'required',
            ],
            'objective' => [
                'string',
                'max:500',
                'nullable',
            ],
            'phase' => [
                'string',
                'max:500',
                'nullable',
            ],
        ];
    }
}
