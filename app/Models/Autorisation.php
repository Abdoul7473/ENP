<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Autorisation extends Model
{
    use HasFactory;

    protected $fillable = [
        'date_autorisation',
        'nombre_route',
        'reference',
        'montant_total',
        'type_autorisation_id',
        'qr_code'
    ];

    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->format('H:i, d M Y');
    }

    public function type_autorisation() {
        return $this->belongsTo(TypeAutorisation::class);
    }

    public function num_autorisations(): HasMany
    {
        return $this->hasMany(NumAutorisation::class);
    }
}
