<?php

namespace App\Http\Requests;

use App\Models\SessionUser;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateSessionUserRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('session_user_edit');
    }

    public function rules()
    {
        return [
            'user_id' => [
                'required',
                'integer',
            ],
            'session_id' => [
                'required',
                'integer',
            ],
            'attachments' => [
                'array',
            ],
            'score' => [
                'nullable',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
        ];
    }
}
