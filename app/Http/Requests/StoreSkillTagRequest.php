<?php

namespace App\Http\Requests;

use App\Models\SkillTag;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreSkillTagRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('skill_tag_create');
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
