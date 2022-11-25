<?php

namespace App\Http\Requests;

use App\Models\ConsultantType;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateConsultantTypeRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('consultant_type_edit');
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
