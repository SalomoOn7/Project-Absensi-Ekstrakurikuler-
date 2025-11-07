<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rekap_bulanan', function (Blueprint $table) {
            $table->id('rekap_id');
            $table->unsignedBigInteger('eskul_id');
           $table->foreign('eskul_id')
          ->references('eskul_id')
          ->on('eskuls')
          ->onDelete('cascade');
          $table->unsignedBigInteger('anggota_id');
            $table->foreign('anggota_id')
                ->references('anggota_id')
                ->on('anggotas')
                ->onDelete('cascade');
            $table->tinyInteger('bulan');
            $table->smallInteger('tahun');
            $table->integer('total_hadir')->default(0);
            $table->integer('total_izin')->default(0);
            $table->integer('total_sakit')->default(0);
            $table->integer('total_alpha')->default(0);
            $table->unsignedBigInteger('dibuat_oleh');
            $table->foreign('dibuat_oleh')
            ->references('user_id') // nama kolom di tabel users
            ->on('users')
            ->onDelete('cascade');
            $table->timestamp('dibuat_pada')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rekap_bulanan');
    }
};
