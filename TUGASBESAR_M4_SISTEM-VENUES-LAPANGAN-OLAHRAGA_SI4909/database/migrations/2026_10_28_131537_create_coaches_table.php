<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('coaches', function (Blueprint $table) {
            $table->id();
            $table->string('kode_coach')->unique(); // e.g. CCH-001
            $table->string('nama_coach');
            $table->string('nomor_telephone_coach');
            $table->string('cabang_olahraga'); // Futsal, Badminton, Basket, dll.
            $table->string('nomor_lisensi'); // AFC, BWF, FIBA
            $table->decimal('tarif_perjam', 10, 2); // Tarif coaching per jam
            $table->enum('status_coach', ['Tersedia', 'Dalam Sesi', 'Sedang Cuti', 'Nonaktif'])->default('Tersedia');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('coaches');
    }
};