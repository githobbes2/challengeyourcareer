<?php

namespace App\Http\Requests;

use App\Models\Event;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateEventRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('event_edit');
    }

    public function rules()
    {
        return [
            'title' => [
                'string',
                'max:100',
                'nullable',
            ],
            'start_time' => [
                'date_format:' . config('panel.date_format') . ' ' . config('panel.time_format_nosecs'),
                'nullable',
            ],
            'duration' => [
                'nullable',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
            'program_types.*' => [
                'integer',
            ],
            'program_types' => [
                'array',
            ],
            'companies.*' => [
                'integer',
            ],
            'companies' => [
                'array',
            ],
            'programs.*' => [
                'integer',
            ],
            'programs' => [
                'array',
            ],
            'development_area_id' => [
                'required',
            ],
            'experience_points' => [
                'nullable',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
        ];
    }
}
