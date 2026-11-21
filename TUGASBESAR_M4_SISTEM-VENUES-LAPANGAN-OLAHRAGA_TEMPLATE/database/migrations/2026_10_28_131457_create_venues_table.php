<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('venues', function (Blueprint $table) {
            $table->id();
            $table->string('kode_lapangan')->unique(); // e.g. LAP-001
            $table->string('nama_lapangan');
            $table->string('tipe_olahraga'); // Futsal, Badminton, Mini Soccer, Basket
            $table->string('jenis_lantai'); // Rumput Sintetis, Vinyl Interlock, Parquet
            $table->string('ukuran_lapangan'); // e.g. 26m x 15m
            $table->enum('status_lapangan', ['Tersedia', 'Maintenance', 'Renovasi', 'Dipesan'])->default('Tersedia');
            $table->decimal('tarif_perjam', 12, 2); // Tarif per jam
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('venues');
    }
};