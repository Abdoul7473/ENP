<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DemandeFichierRequi extends Model
{
    use HasFactory;

    protected $fillable = [
        'date_expire',
        'check',
        'demande_id',
        'fichier_requi_id',
        'fichier'
    ];

    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->format('H:i, d M Y');
    }

    public function demande() {
        return $this->belongsTo(Demande::class);
    }

    public function fichier_requi() {
        return $this->belongsTo(FichierRequi::class);
    }
}
