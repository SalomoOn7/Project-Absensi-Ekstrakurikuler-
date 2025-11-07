<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('anggotas', function (Blueprint $table) {
            $table->id('anggota_id');
            $table->unsignedBigInteger('eskul_id');
           $table->foreign('eskul_id')
          ->references('eskul_id')
          ->on('eskuls')
          ->onDelete('cascade');
            $table->string('nama');
            $table->string('kelas');
            $table->string('nis')->unique();
            $table->enum('jenis_kelamin', ['L', 'P'])->nullable();
            $table->string('no_hp', 20)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
         Schema::dropIfExists('anggotas');
    }
};
