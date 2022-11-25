<?php

namespace App\Http\Requests;

use App\Models\SkillTag;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroySkillTagRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('skill_tag_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:skill_tags,id',
        ];
    }
}
