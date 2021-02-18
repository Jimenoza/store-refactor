<?php

namespace tiendaVirtual\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class ApiCartRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'data' => 'required',
            'data.total' => 'required|numeric|gte:0',
            'data.cart' => 'present|array',
            'error' => 'nullable'
        ];
    }
}
