<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    protected $table = 'order_items';

    protected $fillable = [
        'pesanan_id',
        'layanan_id',
        'jenis_layanan',
        'qty',
        'harga',
    ];

    public function pesanan()
    {
        return $this->belongsTo(Order::class, 'pesanan_id');
    }

    public function layanan()
    {
        return $this->belongsTo(Layanan::class, 'layanan_id');
    }
}
