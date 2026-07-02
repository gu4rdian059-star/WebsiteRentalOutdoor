<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Alat extends Model
{
    protected $table = 'alats';
    protected $primaryKey = 'id_alat';
    public $timestamps = true;

    protected $fillable = [
        'nama_alat',
        'kategori',
        'stok',
        'harga_sewa',
        'gambar',
        'merk',
        'kegunaan',
        'deskripsi'
    ];
}
