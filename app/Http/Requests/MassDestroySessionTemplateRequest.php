<?php

namespace App\Http\Requests;

use App\Models\SessionTemplate;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroySessionTemplateRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('session_template_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:session_templates,id',
        ];
    }
}
