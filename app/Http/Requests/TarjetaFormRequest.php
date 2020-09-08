<?php

namespace tiendaVirtual\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TarjetaFormRequest extends FormRequest
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
            'numero' => 'required|alpha_num|size:16',
            'ccv' => 'required|integer',
            'titular' => 'required',//va a haber un objeto en el html llamado name
            //'imageInput' => 'mimes:jpeg,bmp,png',
            'mes' => 'required|between:1,12',
            'year' => 'required'
        ];
    }

    public function messages()
    {
    return [
        'numero.required' => 'Por favor ingrese un número de tarjeta',
        'numero.alpha_num' => 'Por favor ingrese solo números',
        'numero.size' => 'No ingresó los números suficientes para la tarjeta',
        'ccv.required'  => 'Por favor ingrese un ccv',
        'titular.required'  => 'Por favor ingrese un titular de la tarjeta',
        'mes.required'  => 'Por favor ingrese un mes',
        'year.required'  => 'Por favor ingrese un año'
    ];
    }
}
