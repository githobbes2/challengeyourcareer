<?php

namespace App\Http\Requests;

use App\Models\SessionType;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateSessionTypeRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('session_type_edit');
    }

    public function rules()
    {
        return [
            'name' => [
                'string',
                'max:255',
                'required',
            ],
            'score_required' => [
                'required',
            ],
        ];
    }
}
