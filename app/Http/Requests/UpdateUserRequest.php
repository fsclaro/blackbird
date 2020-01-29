<?php

namespace App\Http\Requests;

use Auth;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('user_edit') || Auth::user()->is_superadmin;
    }

    public function rules()
    {
        if (strlen($this->password) > 0) {
            $password_rule = ['required', 'min:8'];
        } else {
            $password_rule = ['sometimes'];
        }

        return [
            'name'     => ['required'],
            'email'    => ['required', 'email:rfc,dns,spoof', Rule::unique('users')->ignore($this->id)],
            'active'   => ['required', 'integer'],
            'password' => $password_rule,
            'roles'    => ['required', 'integer'],
        ];
    }

    public function messages()
    {
        return [
            'name.required'   => 'Forneça o nome para este usuário',
            'email.required'  => 'Forneça um email válido',
            'email.unique'    => 'Este email já está associado a outro usuário',
            'password.min'    => 'A senha deve ter no mínimo 8 caracteres',
            'active.required' => 'Escolha uma das opções',
            'active.integer'  => 'Escolha uma das opções',
            'roles.required'  => 'Escolha pelo menos um papel para este usuário1',
            'roles.integer'   => 'Escolha pelo menos um papel para este usuário2',
        ];
    }
}
