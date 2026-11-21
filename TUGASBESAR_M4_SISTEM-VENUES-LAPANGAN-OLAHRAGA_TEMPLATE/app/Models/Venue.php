<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venue extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode_lapangan',
        'nama_lapangan',
        'tipe_olahraga',
        'jenis_lantai',
        'ukuran_lapangan',
        'status_lapangan',
        'tarif_perjam',
    ];
}