<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PatientLm extends Model
{
    use HasFactory;

    protected $fillable=[
        'patient_id',
        'lm_id'
    ];

    public function patients(){
        return $this->belongsTo(Patient::class,'patient_id','id');
    }
}
