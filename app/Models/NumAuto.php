<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NumAuto extends Model
{
    use HasFactory;
    protected $fillable = [
        'num',
        'auto',
        'annee'
    ];
}
