<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Auth;

class UpdatePermissionRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('permission_edit') || Auth::user()->is_superadmin;
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
            'title.required'      => 'Forneça um título para esta permissão',
        ];
    }
}
