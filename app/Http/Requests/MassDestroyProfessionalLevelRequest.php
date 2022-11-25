<?php

namespace App\Http\Requests;

use App\Models\ProfessionalLevel;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyProfessionalLevelRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('professional_level_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:professional_levels,id',
        ];
    }
}
