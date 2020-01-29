<?php

namespace App\Http\Requests;

use Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Http\FormRequest;

class UpdateRoleRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('role_edit') || Auth::user()->is_superadmin;
    }

    public function rules()
    {
        return [
            'title'         => ['required'],
            'permissions.*' => ['integer'],
            'permissions'   => ['required', 'array'],
        ];
    }

    public function messages()
    {
        return [
            'title.required'       => 'Forneça uma descrição para este papel',
            'permissions.required' => 'Escolha pelo menos uma permissão da lista de permissões',
        ];
    }
}
