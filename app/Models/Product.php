<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'size',
        'observation',
        'count_inventory',
        'date_boarding',
        'product_id'
    ];

    public function brands() {
        return $this->belongsTo(Brand::class, 'product_id', 'id');
    }
}
