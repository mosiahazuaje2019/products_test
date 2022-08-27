<?php

namespace App\Http\Requests\Invoice;

use Illuminate\Foundation\Http\FormRequest;

class Invoice extends FormRequest
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
            'invoice_number' => 'required|unique:invoices,invoice_number'
        ];
    }

    public function messages() {
        return [
            'invoice_number.required' => 'Debe ingresar un número de factura',
            'invoice_number.unique'   => 'Factura ya existe'
        ];
    }
}
