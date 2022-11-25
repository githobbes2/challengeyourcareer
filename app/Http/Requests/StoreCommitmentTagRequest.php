<?php

namespace App\Http\Requests;

use App\Models\CommitmentTag;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreCommitmentTagRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('commitment_tag_create');
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
