<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Auth;

class UpdateProfileUserRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('user_profile') || Auth::user()->is_superadmin;
    }

    public function rules()
    {
        return [
            'name'    => ['required'],
            'email'   => ['required'],
        ];
    }
}
