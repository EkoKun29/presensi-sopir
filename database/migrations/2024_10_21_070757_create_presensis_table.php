<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('presensis', function (Blueprint $table) {
            $table->id();
            $table->integer('id_user')->nullable();
            $table->string('nama')->nullable();
            $table->string('jabatan')->nullable();
            $table->string('face'); // Kolom untuk menyimpan data face (misal path image)
            $table->date('tanggal'); // Tanggal presensi
            $table->time('jam'); // Waktu presensi
            $table->decimal('latitude', 18, 15)->nullable(); // Kolom latitude
            $table->decimal('longitude', 18, 15)->nullable(); // Kolom longitude
            $table->string('lokasi')->nullable();
            $table->uuid('uuid'); // UUID
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('presensis');
    }
};
