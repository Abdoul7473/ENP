<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Email extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'port',
        'encryption',
        'host',
        'mailer',
        'password',
        'statut',
        'mail_from',
        'name_from'
    ];
}
