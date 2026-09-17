<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Groupe extends Model
{
    use HasFactory;
     protected $fillable = [
        'id',
        'libelle',
        'effectif',
        'corp_id'
    ];
    public function corp() {
        return $this->belongsTo(Corp::class);
    }
}
