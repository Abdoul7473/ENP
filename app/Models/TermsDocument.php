<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TermsDocument extends Model
{
    protected $fillable = [
        'type',
        'filename',
        'original_name',
        'mime_type',
        'uploaded_by',
    ];
}
