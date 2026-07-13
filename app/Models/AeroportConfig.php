<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AeroportConfig extends Model
{
    use HasFactory;
    protected $fillable = [
        'aeroport_id'
    ];
    public function aeroport() {
        return $this->belongsTo(Aeroport::class);
    }
}
