<?php

namespace App\Http\Requests\Products;

use Illuminate\Foundation\Http\FormRequest;

class Product extends FormRequest
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
            'name'            => ['required'],
            'price'           => ['required'],
            'presentation_id' => ['required']
        ];
    }

    public function messages()
    {
        return [
            'name.required'            => 'Debe ingresar un nombre al producto',
            'price.required'           => 'Ingrese precio del producto',
            'presentation_id.required' => 'Debe seleccionar una presentacion del producto'
        ] ;
    }
}
