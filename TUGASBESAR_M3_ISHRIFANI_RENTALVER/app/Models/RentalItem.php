<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RentalItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode_barang',
        'nama_barang',
        'kategori_barang',
        'total_stok',
        'stok_tersedia',
        'kondisi',
        'tarif_sewa',
        'denda_rusak',
    ];
}