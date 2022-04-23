<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PatientLmDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        "product_id",
        "order_id",
        "prescription"
    ];


    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }
}
