<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ligne extends Model
{
    use HasFactory;
     protected $fillable = [
        'id',
        'releve_id',
        'matiere',
        'coefficient',
        'note',
        'note_coefficiente',
        'type'
    ];
    public function releve() {
        return $this->belongsTo(Releve::class);
    }
}
