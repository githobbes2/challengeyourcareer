<?php

namespace App\Http\Requests;

use App\Models\PollAgeScore;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyPollAgeScoreRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('poll_age_score_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:poll_age_scores,id',
        ];
    }
}
