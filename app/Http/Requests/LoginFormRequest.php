<?php

namespace tiendaVirtual\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function rules()
    {
        return [
            'email' => 'required|email',
            'password' => 'required'
            //
        ];
    }
    public function messages()
    {
        return ['email.email' => 'Must be a valid email address'];
    }
}
