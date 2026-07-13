<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Deposit extends Model
{
    use HasFactory;
    protected $fillable = ['virtual_account_id', 'amount', 'code', 'status'];

    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->format('H:i, d M Y');
    }

    public function virtualAccount()
    {
        return $this->belongsTo(VirtualAccount::class);
    }
}
