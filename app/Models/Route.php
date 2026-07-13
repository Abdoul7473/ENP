<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Route extends Model
{
    use HasFactory;
    protected $fillable = [
        'heure_arrive',
        'heure_depart',
        'date_route',
        'remarque',
        'num_autorisation',
        'ville_depart',
        'ville_arrive',
        'demande_id',
        'autorisation_id',
        'check',
    ];
    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->format('H:i, d M Y');
    }

    public function ville_depart() {
        return $this->belongsTo(Aeroport::class,'ville_depart');
    }

    public function ville_arrive() {
        return $this->belongsTo(Aeroport::class,'ville_arrive');
    }

    public function ville_depar() {
        return $this->belongsTo(Aeroport::class,'ville_depart');
    }

    public function ville_arive() {
        return $this->belongsTo(Aeroport::class,'ville_arrive');
    }

    public function autorisation() {
        return $this->belongsTo(Autorisation::class);
    }

    public function demande() {
        return $this->belongsTo(Demande::class);
    }
    
    public function num_autos(): HasMany
    {
        return $this->hasMany(Route::class);
    }
    public function num_autorisations(): HasMany
    {
        return $this->hasMany(NumAutorisation::class);
    }
}
