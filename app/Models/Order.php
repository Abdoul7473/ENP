<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    use HasFactory;
    protected $fillable = [
        'session_id',
        'num_facture',
        'num_facture_format',
        'virtual_account_id',
        'demande_id',
        'postulant_id',
        'prix_total',
        'type',
        'status'
    ];
    
    protected static function booted()
    {
        static::creating(function ($facture) {
            $now = Carbon::now();
            $sequence = Order::whereYear('created_at', $now->year)
                             ->whereMonth('created_at', $now->month)
                             ->count() + 1;
    
            // Format 1: 0001012025
            $facture->num_facture = sprintf('%04d%02d%04d', 
                $sequence,
                $now->month,
                $now->year
            );
    
            // Format 2: 0001/01/2025
            $facture->num_facture_format = sprintf('%04d/%02d/%04d',
                $sequence,
                $now->month,
                $now->year
            );
        });
    }

    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->format('H:i, d M Y');
    }

    public function demande() {
        return $this->belongsTo(Demande::class);
    }
    public function facture_orders(): HasMany
    {
        return $this->hasMany(FactureOrder::class);
    }

    public function postulant() {
        return $this->belongsTo(Postulant::class);
    }

    public function virtualAccount()
    {
        return $this->belongsTo(VirtualAccount::class);
    }
}
