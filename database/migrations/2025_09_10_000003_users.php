<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
       Schema::create('users', function (Blueprint $table) {
            $table->id('user_id');
            $table->unsignedBigInteger('eskul_id')->nullable();
            $table->foreign('eskul_id')
                ->references('eskul_id')
                ->on('eskuls')
                ->onDelete('cascade');
            $table->unsignedBigInteger('anggota_id')->nullable();
            $table->foreign('anggota_id')
                ->references('anggota_id')
                ->on('anggotas')
                ->onDelete('cascade');
            $table->string('nama');
            $table->string('username')->unique();
            $table->string('password');
            $table->enum('role', ['super_admin', 'admin', 'petugas']);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
