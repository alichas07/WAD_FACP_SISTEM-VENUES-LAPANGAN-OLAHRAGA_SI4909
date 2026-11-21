<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coach extends Model
{
    use HasFactory;

    protected $table = 'coaches';

    // Sesuaikan $fillable dengan nama kolom migration baru Anda
    protected $fillable = [
        'kode_coach',
        'nama_coach',
        'nomor_telephone_coach',
        'cabang_olahraga',
        'nomor_lisensi',
        'tarif_perjam',
        'status_coach',
    ];
}