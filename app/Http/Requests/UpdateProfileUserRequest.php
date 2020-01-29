<?php

namespace App\Http\Requests;

use Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Http\FormRequest;

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
