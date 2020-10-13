<?php

namespace tiendaVirtual\Http\Requests\Web;

use Illuminate\Foundation\Http\FormRequest;

class WebCategoriaFormRequest extends FormRequest
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
            'nombre' => 'required|max:45',
            'descripcion' => 'required|max:200',
            'condicion' => 'nullable|integer'
        ];
    }
}
