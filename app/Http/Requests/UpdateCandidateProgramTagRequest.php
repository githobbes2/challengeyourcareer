<?php

namespace App\Http\Requests;

use App\Models\CandidateProgramTag;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateCandidateProgramTagRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('candidate_program_tag_edit');
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
