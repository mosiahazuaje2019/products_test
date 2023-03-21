<?php

namespace App\Http\Requests\PatientDiagnostic;

use Illuminate\Foundation\Http\FormRequest;

class PatientDiagnosticAdd extends FormRequest
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
            'description' => ['required'],
            'patient_id'  => ['required']
        ];
    }

    public function messages() {
        return [
            'description.required' => 'Debe ingresar un diagnóstico',
            'patient_id.required'  => 'Debe seleccionar un paciente'
        ];
    }
}
