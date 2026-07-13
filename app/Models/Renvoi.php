<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Renvoi extends Model
{
    use HasFactory;

    protected $fillable = [
        'date_renvoi',
        'motif_renvoi',
        'statut',
        'demande_id'
    ];

    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->format('H:i, d M Y');
    }
}
