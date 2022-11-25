<?php

namespace App\Http\Requests;

use App\Models\FunctionalArea;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyFunctionalAreaRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('functional_area_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:functional_areas,id',
        ];
    }
}
