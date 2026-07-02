<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransaksiSewa extends Model
{
    protected $table = 'transaksi_sewas';
    protected $primaryKey = 'id_sewa';
    public $timestamps = true;

    protected $fillable = [
        'id_pelanggan',
        'id_alat',
        'tanggal_sewa',
        'tanggal_kembali',
        'jumlah_hari',
        'jumlah_satuan',
        'total_harga',
        'denda',
        'status',
        'user_id',
        'payment_status',
        'payment_method',
        'payment_confirmed_at',
        'confirmed_by',
        'order_group_id',
    ];

    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class, 'id_pelanggan', 'id_pelanggan');
    }

    public function alat()
    {
        return $this->belongsTo(Alat::class, 'id_alat', 'id_alat');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
