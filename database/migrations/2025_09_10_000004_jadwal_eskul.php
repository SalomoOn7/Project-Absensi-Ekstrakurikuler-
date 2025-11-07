<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
 
    public function up(): void
    {
            Schema::create('jadwal_eskul', function (Blueprint $table) {
            $table->id('jadwal_id');
            $table->unsignedBigInteger('eskul_id');
           $table->foreign('eskul_id')
          ->references('eskul_id')
          ->on('eskuls')
          ->onDelete('cascade');
            $table->enum('hari', ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu']);
            $table->time('waktu_mulai');
            $table->time('waktu_selesai');
            $table->timestamps();
            });
    }

    public function down(): void
    {
        Schema::dropIfExists('jadwal_eskul');
    }
};
