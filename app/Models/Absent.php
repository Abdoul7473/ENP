<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Absent extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'eleve_id',
        'situation_id'
    ];
     public function eleve(): BelongsTo
    {
        return $this->belongsTo(Eleve::class);
    }
    public function situation(): BelongsTo
    {
        return $this->belongsTo(Situation::class);
    }
}
