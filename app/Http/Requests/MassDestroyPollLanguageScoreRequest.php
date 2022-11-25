<?php

namespace App\Http\Requests;

use App\Models\PollLanguageScore;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyPollLanguageScoreRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('poll_language_score_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:poll_language_scores,id',
        ];
    }
}
