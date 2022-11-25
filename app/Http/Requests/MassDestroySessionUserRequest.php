<?php

namespace App\Http\Requests;

use App\Models\SessionUser;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroySessionUserRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('session_user_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:session_users,id',
        ];
    }
}
