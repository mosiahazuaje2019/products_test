<?php

namespace App\Http\Requests\PatientAddress;

use Illuminate\Foundation\Http\FormRequest;

class PatientAddressAdd extends FormRequest
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
            'name'       => ['required'],
            'category'   => ['required'],
            'patient_id' => ['required']
        ];
    }

    public function messages() {
        return [
            'name.required'       => 'Debe ingresar un número de teléfono o dirección dependiendo de la acción que este ejecutando.',
            'category.required'   => 'Debe ingresar un valor para la categoría',
            'patient_id.required' => 'Debe ingresar un valor para el paciente'
        ];
    }
}
