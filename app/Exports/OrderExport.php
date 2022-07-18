<?php

namespace App\Exports;

use App\Models\PatientLmDetail;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Cell\Cell;
use Maatwebsite\Excel\Concerns\ToModel;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use Maatwebsite\Excel\Concerns\WithCustomValueBinder;
use PhpOffice\PhpSpreadsheet\Cell\DefaultValueBinder;
use \Maatwebsite\Excel\Sheet;


class OrderExport extends DefaultValueBinder implements  FromView, ShouldAutoSize, WithStyles, WithCustomValueBinder
{
    public function bindValue(Cell $cell, $value)
    {
        if (is_numeric($value)) {
            $cell->setValueExplicit($value, DataType::TYPE_NUMERIC);

            return true;
        }

        // else return default behavior
        return parent::bindValue($cell, $value);
    }

    public function styles(Worksheet $sheet)
    {
        $styleArray = [
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            ],
            'borders' => [
                'outline' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
                    'color' => ['argb' => '00000000'],
                ],
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => [
                    'argb' => 'f0f0f0',
                ],
                'endColor' => [
                    'argb' => 'f0f0f0',
                ],
            ],
            'font' => [
                'bold' => true,
            ],
        ];
        $styleAlign = [
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            ],
        ];
        $sheet->getStyle('A2:H2')->applyFromArray($styleArray);
        $sheet->getStyle('A3:H3')->applyFromArray($styleArray);
        $sheet->getStyle('A4:H4')->applyFromArray($styleArray);
        $sheet->getStyle('C')->applyFromArray($styleAlign);
    }

    public function __construct(int $invoice){
        $this->invoice = $invoice;
    }

    public function view(): View
    {
        $query = PatientLmDetail::with(['product', 'patient'])->whereHas('order', function($query){
            return $query->where('invoice_number',$this->invoice);
        })->get()->groupBy('order.id');

        return view('patients.orders', [
            'orders' => $query
        ]);
    }
}
