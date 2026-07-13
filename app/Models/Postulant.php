<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Postulant extends Model
{
    use HasFactory;
    protected $fillable = [
        'code',
        'nom_raison_sociale',
        'tel',
        'tel2',
        'email',
        'adresse',
        'fonction',
        "type_postulant_id",
        "numero_ordre",
        "ville_id",
        "fichier",
        "signature_cachet"
    ];
    // public function getTelAttribute($value): array
    // {
    //     return json_decode($value, true) ?? [];
    // }

    // public function setTelAttribute($value): void
    // {
    //     $properties = [];

    //     foreach ($value as $array_item) {
    //         if ($array_item) {
    //             $properties[] = $array_item;
    //         }
    //     }

    //     $this->attributes['tel'] = json_encode($properties);
    // }
    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->format('H:i, d M Y');
    }

    public function type_postulant() {
        return $this->belongsTo(TypePostulant::class);
    }
    public function ville() {
        return $this->belongsTo(Ville::class);
    }
    
    protected static function booted()
    {
        static::creating(function ($facture) {
            // $count = Postulant::withTrashed()->count(); // Compte toutes les entrées (même supprimées)
            $count = Postulant::count();
            $facture->code = 'C' . str_pad($count + 1, 3, '0', STR_PAD_LEFT);
        });
    }
}
