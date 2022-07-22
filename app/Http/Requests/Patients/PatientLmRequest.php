<?php

namespace App\Http\Requests\Patients;

use Illuminate\Foundation\Http\FormRequest;

class PatientLmRequest extends FormRequest
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
            'phone_id'      => ['required'],
            'address_id'    => ['required'],
            'diagnostic_id' => ['required'],
        ];
    }

    public function messages()
    {
        return [
            'phone_id.required'      => 'Número de teléfono es obligatorio',
            'address_id.required'    => 'Debe ingresar una dirección',
            'diagnostic_id.required' => 'Debe ingresar un diagnóstico'
        ];
    }
}
