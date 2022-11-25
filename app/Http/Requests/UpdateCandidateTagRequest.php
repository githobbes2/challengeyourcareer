<?php

namespace App\Http\Requests;

use App\Models\CandidateTag;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateCandidateTagRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('candidate_tag_edit');
    }

    public function rules()
    {
        return [
            'name' => [
                'string',
                'max:255',
                'required',
            ],
        ];
    }
}
