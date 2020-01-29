<?php

namespace App\Http\Requests;

use Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Http\FormRequest;

class StorePermissionRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('permission_create') || Auth::user()->is_superadmin;
    }

    public function rules()
    {
        return [
            'title'      => ['required'],
        ];
    }

    public function messages()
    {
        return [
            'title.required'      => 'Forneça um descrição para esta permissão',
        ];
    }
}
