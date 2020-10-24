<?php

namespace tiendaVirtual\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class ApiOrderFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if($this->user()){
            return true;
        }
        else{
            return false;
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "address" => "required|max:255"
        ];
    }

    public function messages(){
        return [
            'address.required' => 'An address is required',
            'address.max' => 'Address must be less than 255 char'
        ];
    }
}
