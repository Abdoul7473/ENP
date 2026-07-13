<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Signature extends Model
{
    use HasFactory;
    protected $fillable = [
        'libelle',
        'user_id',
    ];
    public function signature(): BelongsTo
    {
        return $this->belongsTo(TypeUser::class);
    }
}
