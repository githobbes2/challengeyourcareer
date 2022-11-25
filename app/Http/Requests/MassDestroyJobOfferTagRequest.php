<?php

namespace App\Http\Requests;

use App\Models\JobOfferTag;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyJobOfferTagRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('job_offer_tag_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:job_offer_tags,id',
        ];
    }
}
