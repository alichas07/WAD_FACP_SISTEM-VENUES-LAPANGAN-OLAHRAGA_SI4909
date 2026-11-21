<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('members', function (Blueprint $table) {
            $table->id();
            $table->string('kode_member')->unique(); // e.g. MBR-001
            $table->string('nama_member');
            $table->string('nomor_telephone_member');
            $table->string('email_member')->nullable();
            $table->enum('level_member', ['Basic', 'Gold', 'VIP'])->default('Basic');
            $table->enum('status', ['Aktif', 'Suspend', 'Expired'])->default('Aktif');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('members');
    }
};