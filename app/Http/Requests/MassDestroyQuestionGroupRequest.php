<?php

namespace App\Http\Requests;

use App\Models\QuestionGroup;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyQuestionGroupRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('question_group_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:question_groups,id',
        ];
    }
}
