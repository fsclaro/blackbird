<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileUserRequest extends FormRequest
{
    public function authorize()
    {
        return \Gate::allows('user_profile');
    }

    public function rules()
    {
        return [
            'name'    => ['required'],
            'email'   => ['required'],
        ];
    }
}
