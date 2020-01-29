<?php

namespace App\Http\Requests;

use Auth;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('user_create') || Auth::user()->is_superadmin;
    }

    public function rules()
    {
        return [
            'name'     => ['required'],
            'email'    => ['required', 'email:rfc,dns,spoof', Rule::unique('users')->ignore($this->id)],
            'password' => ['required', 'min:8'],
            'active'   => ['required', 'integer'],
            'roles'    => ['required', 'integer'],
        ];
    }

    public function messages()
    {
        return [
            'name.required'     => 'Forneça o nome para este usuário',
            'email.required'    => 'Forneça um email válido',
            'email.unique'      => 'Este email já está associado a outro usuário',
            'password.required' => 'Forneça uma senha válida para este usuário',
            'password.min'      => 'A senha deve ter no mínimo 8 caracteres',
            'active.required'   => 'Escolha uma das opções',
            'active.integer'    => 'Escolha uma das opções',
            'roles.required'    => 'Escolha pelo menos um papel para este usuário',
            'roles.integer'     => 'Escolha pelo menos um papel para este usuário'
        ];
    }
}
