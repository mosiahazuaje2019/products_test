<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class PatientAdress extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'category',
        'patient_id'
    ];

    public function patient()  {
        return $this->belongsTo(Patient::class, 'patient_id', 'id');
    }

}
