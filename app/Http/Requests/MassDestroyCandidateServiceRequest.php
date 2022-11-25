<?php

namespace App\Http\Requests;

use App\Models\CandidateService;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyCandidateServiceRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('candidate_service_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:candidate_services,id',
        ];
    }
}
