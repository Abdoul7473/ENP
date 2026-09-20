<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Evaluation extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'enseignant_groupe_modulo_id',
        'date_evaluation',
        'assistant1',
        'assistant2',
        'type_evaluation'
    ];

    public function enseignant_groupe_modulo() {
        return $this->belongsTo(EnseignantGroupeModulo::class);
    }
}
