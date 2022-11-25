<?php

namespace App\Http\Requests;

use App\Models\Language;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreLanguageRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('language_create');
    }

    public function rules()
    {
        return [
            'name' => [
                'string',
                'max:255',
                'required',
            ],
            'short_code' => [
                'string',
                'max:5',
                'required',
            ],
        ];
    }
}
