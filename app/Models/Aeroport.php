<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Aeroport extends Model
{
    use HasFactory,SoftDeletes;
    protected $fillable = [
        'nom',
        'code_iata',
        'code_icao',
        'region',
        'pays',
    ];
}
