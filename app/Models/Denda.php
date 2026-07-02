<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Denda extends Model
{
    use HasFactory;

    protected $table = 'dendas'; // Nama tabel
    protected $primaryKey = 'id_denda'; // Primary key
    public $incrementing = true;  // Auto increment
    protected $keyType = 'int';   // Integer

    protected $fillable = [
        'id_sewa',
        'tanggal_denda',
        'jenis_denda',
        'batas_waktu',
        'total_denda',
        'potongan_denda',
        'alasan_potongan',
        'diputuskan_oleh',
        'tanggal_potongan',
    ];

    protected $casts = [
        'tanggal_denda' => 'date',
        'batas_waktu' => 'date',
        'tanggal_potongan' => 'datetime',
    ];

    // Append calculated attributes
    protected $appends = ['denda_akhir'];

    // RELASI KE TRANSAKSI SEWA
    public function transaksiSewa()
    {
        return $this->belongsTo(TransaksiSewa::class, 'id_sewa', 'id_sewa');
    }

    // RELASI KE USER (ADMIN YANG MEMBERIKAN POTONGAN)
    public function adminPelayu()
    {
        return $this->belongsTo(User::class, 'diputuskan_oleh', 'id');
    }

    // ✨ HITUNG DENDA AKHIR (TOTAL - POTONGAN)
    public function getDendaAkhirAttribute()
    {
        $dendaAkhir = $this->total_denda - ($this->potongan_denda ?? 0);
        return max(0, $dendaAkhir); // Tidak boleh negatif
    }

    // 🎯 CEK APAKAH SUDAH ADA POTONGAN
    public function hasPotong()
    {
        return $this->potongan_denda > 0;
    }

    // 💯 GET PERSENTASE POTONGAN
    public function getPersentasePotong()
    {
        if ($this->total_denda == 0) return 0;
        return round(($this->potongan_denda / $this->total_denda) * 100, 2);
    }
}

