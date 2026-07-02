<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pelanggan extends Model
{
    protected $table = 'pelanggans';
    protected $primaryKey = 'id_pelanggan';

    public $incrementing = true;     // ✅ AUTO INCREMENT
    protected $keyType = 'int';      // ✅ INTEGER
    public $timestamps = false;      // sesuaikan DB kamu

    protected $fillable = [
        'nama_pelanggan',
        'alamat_pelanggan',
        'no_telepon',
        'email_pelanggan',
    ];
}
