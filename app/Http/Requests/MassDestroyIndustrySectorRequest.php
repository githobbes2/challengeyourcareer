<?php

namespace App\Http\Requests;

use App\Models\IndustrySector;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyIndustrySectorRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('industry_sector_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:industry_sectors,id',
        ];
    }
}
