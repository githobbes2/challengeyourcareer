<?php

namespace App\Http\Requests;

use App\Models\CandidateTag;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyCandidateTagRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('candidate_tag_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:candidate_tags,id',
        ];
    }
}
