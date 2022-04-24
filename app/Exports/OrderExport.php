<?php

namespace App\Exports;

use App\Models\PatientLmDetail;
use Maatwebsite\Excel\Concerns\FromQuery;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class OrderExport implements FromView
{

    public function view(): View
    {
        return view('patients.orders', [
            'orders' => PatientLmDetail::with(['product', 'order'])->get()
        ]);
    }
}
