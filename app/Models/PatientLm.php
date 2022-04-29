<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PatientLm extends Model
{
    use HasFactory;

    protected $fillable=[
        'patient_id',
        'date_ini',
        'date_end',
        'diagnostic',
    ];

    public function patient(){
        return $this->belongsTo(Patient::class,'patient_id','id');
    }

    public function orders(){
        return $this->hasMany(PatientLmDetail::class,  'order_id', 'id');
    }
}
