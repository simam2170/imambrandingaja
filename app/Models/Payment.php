<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $table = 'pembayaran';

    protected $fillable = [
        'pesanan_id',
        'metode_pembayaran',
        'bukti_pembayaran',
        'total_bayar',
        'status',
        'tanggal_bayar',
    ];
    
    protected $casts = [
        'tanggal_bayar' => 'datetime',
    ];

    public function pesanan()
    {
        return $this->belongsTo(Order::class, 'pesanan_id');
    }
}
