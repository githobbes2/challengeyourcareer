<?php

namespace App\Http\Requests;

use App\Models\UserNoteTag;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreUserNoteTagRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('user_note_tag_create');
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
