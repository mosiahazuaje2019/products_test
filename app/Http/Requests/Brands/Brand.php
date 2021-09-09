<?php

namespace App\Http\Requests\Brands;

use Illuminate\Foundation\Http\FormRequest;

class Brand extends FormRequest
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
            'name'      => ['required'],
            'reference' => 'required|unique:brands'
        ];
    }

    public function messages()
    {
        return [
            'name.required'      => 'Es necesario un nombre para la marca',
            'reference.required' => 'Debe indicar una referencia',
            'reference.unique'   => 'La referencia que intenta registrar ya se encuentra asociada a otra marca'
        ] ;
    }
}
