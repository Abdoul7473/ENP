<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'demande_id',
        'order_id',
        'postulant_id',
        'user_id',
        'mode',
        'amount',
        'receipt_no',
        'receipt_no_format',
        'status',
        'motif',
    ];

    protected static function booted()
    {
        static::creating(function ($payment) {
            $now = Carbon::now();
            $sequence = Payment::whereYear('created_at', $now->year)
                ->whereMonth('created_at', $now->month)
                ->count() + 1;

            $payment->receipt_no = sprintf('%04d%02d%04d',
                $sequence,
                $now->month,
                $now->year
            );

            $payment->receipt_no_format = sprintf('%04d/%02d/%04d',
                $sequence,
                $now->month,
                $now->year
            );
        });
    }

    public function demande()
    {
        return $this->belongsTo(Demande::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function postulant()
    {
        return $this->belongsTo(Postulant::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
