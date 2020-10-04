<?php

namespace tiendaVirtual\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CommentProductRequest extends FormRequest
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
            'rate' => 'required|integer',
            'comment' => 'required|max:300'
        ];
    }

    public function messages(){
        return [
            'rate.required' => 'Una calificación es requerida',
            'comment.max' => 'El comentario es muy largo'
        ];
    }
}
