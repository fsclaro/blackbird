<?php

namespace App\Http\Requests;

use Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Http\FormRequest;

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
