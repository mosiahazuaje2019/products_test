<?php

namespace App\Http\Requests\PatientLm;

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
            'lm_code'       => 'required',
            'authorized_by' => 'required'
        ];
    }

    public function messages(){
        return [
            'lm_code.required'       => 'Debe ingresar un codigo LM',
            'authorized_by.required' => 'Debe ingresar quien autoriza la orden'
        ];
    }
}
