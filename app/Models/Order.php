<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $table = 'pesanan';

    protected $fillable = [
        'order_number',
        'user_id',
        'mitra_id',
        'layanan_branding_id',
        'paket',
        'jumlah',
        'total_harga',
        'status',
        'total',
        'bukti_pembayaran',
        'bukti_selesai',
        'bukti_transfer_mitra',
        'metode_pembayaran',
        'expired_at',
        'catatan',
        'reviewed_at',
    ];

    protected $casts = [
        'expired_at' => 'datetime',
        'reviewed_at' => 'datetime',
    ];

    public function isExpired()
    {
        return $this->expired_at && $this->expired_at->isPast();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function mitra()
    {
        return $this->belongsTo(Mitra::class, 'mitra_id');
    }

    // Alias for compatibility if needed
    public function jaringan()
    {
        return $this->mitra();
    }

    public function layanan()
    {
        return $this->belongsTo(Layanan::class, 'layanan_branding_id');
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class, 'pesanan_id');
    }

    public function payment()
    {
        return $this->hasOne(Payment::class, 'pesanan_id');
    }

    public function review()
    {
        return $this->hasOne(Review::class, 'order_id');
    }

    public function portofolio()
    {
        return $this->hasOne(Portofolio::class, 'order_id');
    }

    /**
     * Get the timeline of the order.
     *
     * @return array
     */
    public function getTimelineAttribute()
    {
        $timeline = [];

        // 1. Pesanan Dibuat (Always exists)
        $timeline[] = [
            'status' => 'Pesanan Dibuat',
            'desc' => 'Pesanan berhasil dibuat dan menunggu pembayaran.',
            'time' => $this->created_at->setTimezone('Asia/Jakarta')->format('d M H:i') . ' WIB',
            'active' => true,
        ];

        // 2. Pembayaran (If proof exists or status advanced)
        if ($this->bukti_pembayaran || in_array($this->status, ['direview', 'diproses', 'selesai'])) {
            $paymentTime = $this->payment ? $this->payment->created_at : $this->updated_at; // Fallback
            $timeline[] = [
                'status' => 'Pembayaran Diupload',
                'desc' => 'Bukti pembayaran telah diupload.',
                'time' => $paymentTime ? $paymentTime->setTimezone('Asia/Jakarta')->format('d M H:i') . ' WIB' : '-',
                'active' => true,
            ];
        }

        // 3. Diproses (If status is diproses or selesai)
        if (in_array($this->status, ['diproses', 'selesai'])) {
            $timeline[] = [
                'status' => 'Pesanan Diproses',
                'desc' => 'Pesanan sedang dikerjakan oleh mitra.',
                'time' => $this->updated_at->setTimezone('Asia/Jakarta')->format('d M H:i') . ' WIB', // Approximation
                'active' => true,
            ];
        }

        // 4. Selesai (If status is selesai)
        if ($this->status == 'selesai') {
            $timeline[] = [
                'status' => 'Pesanan Selesai',
                'desc' => 'Pesanan telah selesai dikerjakan.',
                'time' => $this->updated_at->setTimezone('Asia/Jakarta')->format('d M H:i') . ' WIB',
                'active' => true,
            ];
        }

        // 5. Dibatalkan/Ditolak
        if (in_array($this->status, ['dibatalkan', 'ditolak'])) {
            $timeline[] = [
                'status' => 'Pesanan ' . ucfirst($this->status),
                'desc' => 'Pesanan telah ' . $this->status . '.',
                'time' => $this->updated_at->setTimezone('Asia/Jakarta')->format('d M H:i') . ' WIB',
                'active' => true,
            ];
        }

        return $timeline;
    }
}
