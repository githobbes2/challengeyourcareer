<?php

namespace App\Http\Requests;

use App\Models\ConsultantType;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyConsultantTypeRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('consultant_type_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:consultant_types,id',
        ];
    }
}
