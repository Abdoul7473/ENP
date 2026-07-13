<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class NumAutorisation extends Model
{
    use HasFactory;

    protected $fillable = [
        'numero',
        'code',
        'num_facture',
        'num_facture_format',
        'ref_article',
        'autorisation_id',
        'route_id',
        'revise',
        'statut',
    ];
    
    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->format('H:i, d M Y');
    }

    public function autorisation() {
        return $this->belongsTo(Autorisation::class);
    }

    public function route() {
        return $this->belongsTo(Route::class);
    }

    
}
