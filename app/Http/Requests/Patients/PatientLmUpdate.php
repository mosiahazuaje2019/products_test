<?php

namespace App\Http\Requests\Patients;

use Illuminate\Foundation\Http\FormRequest;

class PatientLmUpdate extends FormRequest
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
            'lm_code' => 'required|unique:patient_lms,lm_code'
        ];
    }

    public function messages(){
        return [
            'lm_code.required' => 'Debe ingresar un codigo LM',
            'lm_code.unique'   => 'Este codigo LM|EC ya se encuentra registrado'
        ];
    }
}
