<?php

namespace App\Http\Requests;

use App\Models\Session;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreSessionRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('session_create');
    }

    public function rules()
    {
        return [
            'title' => [
                'string',
                'max:255',
                'required',
            ],
            'user_id' => [
                'required',
                'integer',
            ],
            'session_type_id' => [
                'required',
                'integer',
            ],
            'start_time' => [
                'required',
                'date_format:' . config('panel.date_format') . ' ' . config('panel.time_format_nosecs'),
            ],
            'duration' => [
                'required',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
            'location' => [
                'string',
                'max:500',
                'nullable',
            ],
            'status' => [
                'required',
            ],
            'attachments' => [
                'array',
            ],
            'manager_score' => [
                'nullable',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
            'development_area_id' => [
                'required',
            ],
        ];
    }
}
