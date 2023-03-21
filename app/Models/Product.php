<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'presentation',
        'price',
        'presentation_id'
    ];

    public function presentation() {
        return $this->belongsTo(Presentation::class);
    }
}
