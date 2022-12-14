<?php

namespace App\Http\Requests;

use App\Models\CommitmentTag;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyCommitmentTagRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('commitment_tag_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:commitment_tags,id',
        ];
    }
}
