<?php

namespace tiendaVirtual\Http\Requests\Web;

use Illuminate\Foundation\Http\FormRequest;

class WebProductFormRequest extends FormRequest
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
     *  Rules apply for create a new product and edit a new product
     * @return array
     */
    public function rules()
    {
        return [
            'nombre' => 'required',
            'descripcion' => 'required',
            'imageInput' => 'required|image',
            'precio' => 'required|numeric',
            'categorias' => 'required|integer',
            'disponibles' => 'required|integer'
        ];
    }
}
