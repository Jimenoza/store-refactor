<?php

namespace tiendaVirtual\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class ApiCategoryFormRequest extends FormRequest
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
            'name' => 'required|max:45',
            'description' => 'required|max:200',
            'condition' => 'nullable|integer'
        ];
    }

    public function messages(){
        return [
            'name.required' => 'A name is required',
            'description.required' => 'A description is required',
            'description.max' => 'Description can not be longer than 200 chars',
            'condition.integer' => 'Condition must be an integer'
        ];
    }
}
