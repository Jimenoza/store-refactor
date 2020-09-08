<?php

namespace tiendaVirtual\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductoFormRequest extends FormRequest
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
            'categorias' => 'integer',
            'nombre' => 'required|max:45',//va a haber un objeto en el html llamado name
            'descripcion' => 'required|max:200', //va a haber un objeto en el html llamado description que no va a ser requerido
            //'imageInput' => 'mimes:jpeg,bmp,png',
            'precio' => 'required|between:0,999999999999.99',
            'disponibles' => 'required|integer'
        ];
    }
}
