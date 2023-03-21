<?php

namespace App\Http\Requests\Patients;

use Illuminate\Foundation\Http\FormRequest;

class PatientUpdate extends FormRequest
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
            'personal_id' => ['required'],
            'age'         => ['required'],
            'city_id'     => ['required']
        ];
    }

    public function messages()
    {
        return [
            'first_name.required'  => 'Debe ingresar nombre del paciente',
            'last_name.required'   => 'Debe ingresar apellido del paciente',
            'personal_id.required' => 'Debe ingresar un numero de cedula',
            'age.required'         => 'Debe ingresar su edad',
            'city_id.required'     => 'Debe seleccionar una ciudad'
        ];
    }
}
