<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailSewa extends Model
{
    protected $table = 'detail_sewas';

    protected $fillable = [
        'id_sewa',
        'id_alat',
        'jumlah',
        'subtotal',
    ];

    public function alat()
    {
        return $this->belongsTo(Alat::class, 'id_alat', 'id_alat');
    }
}
