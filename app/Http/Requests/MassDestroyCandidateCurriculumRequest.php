<?php

namespace App\Http\Requests;

use App\Models\CandidateCurriculum;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyCandidateCurriculumRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('candidate_curriculum_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:candidate_curriculums,id',
        ];
    }
}
