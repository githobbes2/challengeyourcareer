<?php

namespace App\Http\Requests;

use App\Models\UserNote;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreUserNoteRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('user_note_create');
    }

    public function rules()
    {
        return [
            'title' => [
                'string',
                'max:255',
                'required',
            ],
            'tags.*' => [
                'integer',
            ],
            'tags' => [
                'array',
            ],
        ];
    }
}
