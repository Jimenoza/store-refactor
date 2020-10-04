<?php

namespace tiendaVirtual\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductSearchRequest extends FormRequest
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
            'searcher' => 'required',
            'categoryFilter' => 'nullable|integer'
            //
        ];
    }
    public function messages()
    {
        return ['searcher.required' => 'search filter is requiered',
                'categoryFilter.integer' => 'categoryFilter must be a number'];
    }
}
