<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
         Schema::create('absensis', function (Blueprint $table) {
            $table->id('absensi_id');
            $table->unsignedBigInteger('anggota_id');
            $table->unsignedBigInteger('eskul_id');
            $table->unsignedBigInteger('jadwal_id')->nullable();
            $table->unsignedBigInteger('user_id');

            $table->date('tanggal');
            $table->enum('status', ['Hadir', 'Izin', 'Sakit', 'Alpha']);
            $table->text('keterangan')->nullable();
            $table->timestamps();

            // Biar 1 anggota hanya bisa diabsen 1x per tanggal
            $table->unique(['anggota_id', 'tanggal']);

            $table->foreign('anggota_id')
            ->references('anggota_id')
            ->on('anggotas')
            ->onDelete('cascade');

            $table->foreign('eskul_id')
                ->references('eskul_id')
                ->on('eskuls')
                ->onDelete('cascade');

            $table->foreign('jadwal_id')
                ->references('jadwal_id')
                ->on('jadwal_eskul')
                ->onDelete('set null');

            $table->foreign('user_id')
                ->references('user_id')
                ->on('users')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('absensis');
    }
};
