<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'note',
        'eleve_id',
        'evaluation_id',
    ];
    public function eleve() {
        return $this->belongsTo(Eleve::class);
    }
     public function evaluation() {
        return $this->belongsTo(Evaluation::class);
    }
}
