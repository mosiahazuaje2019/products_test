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
            'size'            => ['required'],
            'observation'     => ['required'],
            'count_inventory' => 'required|numeric',
            'date_boarding'   => ['required'],
            'brand_id'        => ['required']
        ];
    }

    public function messages()
    {
        return [
            'name.required'            => 'Debe ingresar un nombre al producto',
            'size.required'            => 'Seleccione una talla',
            'observation.required'     => 'Escriba una observación',
            'count_inventory.required' => 'Indique cantidad en inventario',
            'count_inventory.numeric'  => 'La cantidad debe ser un valor númerico entero',
            'date_boarding.required'   => 'Seleccione fecha de embarque',
            'brand_id.required'        => 'Debe asociar a una marca'
        ] ;
    }
}
