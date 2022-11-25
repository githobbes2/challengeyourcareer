<?php

namespace App\Http\Requests;

use App\Models\IndustrySector;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateIndustrySectorRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('industry_sector_edit');
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
