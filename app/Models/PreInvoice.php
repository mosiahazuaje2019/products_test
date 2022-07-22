<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PreInvoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_lms_id',
        'total_items',
        'lm_code',
        'status'
    ];

    public function patient_lms()
    {
        return $this->belongsTo(PatientLm::class);
    }
}
