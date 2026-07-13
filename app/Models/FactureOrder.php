<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FactureOrder extends Model
{
    use HasFactory;
    protected $fillable = [
        'facture_id',
        'order_id',
    ];

    public function facture() {
        return $this->belongsTo(Facture::class);
    }

    public function order() {
        return $this->belongsTo(Order::class);
    }
}
