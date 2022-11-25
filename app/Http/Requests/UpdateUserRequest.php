<?php

namespace App\Http\Requests;

use App\Models\User;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateUserRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('user_edit');
    }

    public function rules()
    {
        return [
            'name' => [
                'string',
                'max:255',
                'required',
            ],
            'lastname' => [
                'string',
                'max:255',
                'nullable',
            ],
            'email' => [
                'required',
                'unique:users,email,' . request()->route('user')->id,
            ],
            'phone' => [
                'string',
                'max:255',
                'nullable',
            ],
            'birthday' => [
                'date_format:' . config('panel.date_format'),
                'nullable',
            ],
            'government_number' => [
                'string',
                'max:255',
                'nullable',
            ],
            'passport' => [
                'string',
                'max:255',
                'nullable',
            ],
            'languages.*' => [
                'integer',
            ],
            'languages' => [
                'array',
            ],
            'social_linkedin' => [
                'string',
                'max:255',
                'nullable',
            ],
            'roles.*' => [
                'integer',
            ],
            'roles' => [
                'required',
                'array',
            ],
        ];
    }
}
