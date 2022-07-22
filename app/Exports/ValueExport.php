<?php

namespace App\Exports;

use App\Models\patient_lm_details;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromView;

class ValueExport implements FromView
{
    /**
     * @return View
     */
    public function view():View
    {
        $query = DB::select('select p.first_name, p.last_name, p.personal_id,  pl.lm_code,  SUM(p2.price * pld.prescription) as total, pl.id
from patient_lm_details pld
INNER JOIN patients p on p.id = pld.patient_id
INNER JOIN patient_lms pl on pld.order_id = pl.id
INNER JOIN products p2 on pld.product_id = p2.id
where pl.lm_code <> "" and pl.invoice_number IS NOT NULL
GROUP BY p.first_name, p.last_name, p.personal_id, pl.lm_code, pl.id
ORDER BY pl.invoice_number, pl.id ');

        return view('report_values.values', [
            'patients' => $query
        ]);
    }
}
