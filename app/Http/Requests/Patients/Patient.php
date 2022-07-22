<?php

namespace App\Http\Requests\Patients;

use Illuminate\Foundation\Http\FormRequest;

class Patient extends FormRequest
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
            'first_name'  => ['required'],
            'last_name'   => ['required'],
            'personal_id' => 'required|unique:patients,personal_id',
            'age'         => ['required'],
            'city_id'     => ['required']
        ];
    }

    public function messages()
    {
        return [
            'first_name.required'  => 'Debe ingresar el nombre del paciente',
            'last_name.required'   => 'Debe ingresar el apellido del paciente',
            'personal_id.required' => 'Debe ingresar el número de cédula',
            'personal_id.unique'   => 'Este número de cédula ya se encuentra registrado',
            'age.required'         => 'Ingrese la edad',
            'city_id.required'     => 'Seleccione una ciudad'
        ];
    }
}
