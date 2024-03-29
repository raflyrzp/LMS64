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
        Schema::create('pelajarans', function (Blueprint $table) {
            $table->id();
            $table->string('mata_pelajaran');
            $table->foreignId('id_kelas')->constrained('kelas');
            $table->foreignId('id_guru')->constrained('users');
            $table->string('deskripsi');
            $table->text('foto');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pelajarans');
    }
};
