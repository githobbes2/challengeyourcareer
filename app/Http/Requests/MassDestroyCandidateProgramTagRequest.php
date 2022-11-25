<?php

namespace App\Http\Requests;

use App\Models\CandidateProgramTag;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyCandidateProgramTagRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('candidate_program_tag_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:candidate_program_tags,id',
        ];
    }
}
