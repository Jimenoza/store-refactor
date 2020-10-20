<?php

namespace tiendaVirtual\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class ApiProductFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->admin;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required',
            'description' => 'required',
            'image' => 'required|image',
            'price' => 'required|numeric|gt:0',
            'category' => 'required|integer',
            'stock' => 'required|integer'
        ];
    }

    public function messages(){
        return [
            'name.required' => 'A name is required',
            'description.required' => 'A description is required',
            'image.required' => 'An image is required',
            'image.image' => 'Must be a valid image',
            'price.required' => 'A price is required',
            'price.gt' => 'Price must be greater than 0',
            'category.required' => 'A category is needed',
            'category.integer' => 'Must be a integer',
            'stock.required' => 'A stock is needed',
            'stock.integer' => 'Must be a integer',
        ];
    }
}
