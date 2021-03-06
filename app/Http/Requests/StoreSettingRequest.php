<?php

namespace App\Http\Requests;

use Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Http\FormRequest;

class StoreSettingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Gate::allows('setting_create') || Auth::user()->is_superadmin;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'description' => ['required'],
            'type'        => ['required'],
        ];
    }

    public function messages()
    {
        return [
            'description.required' => 'Forneça uma descrição para este parâmetro',
            'type.required'        => 'Escolha uma das opções deste parâmetro',
        ];
    }
}
