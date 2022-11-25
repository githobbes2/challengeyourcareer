<?php

namespace App\Http\Requests;

use App\Models\UserNoteTag;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateUserNoteTagRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('user_note_tag_edit');
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
