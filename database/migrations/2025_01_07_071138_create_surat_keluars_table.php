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
        Schema::create('surat_keluars', function (Blueprint $table) {
            $table->id();
            $table->integer('agenda');
            $table->date('tanggal_surat');
            $table->string('tujuan');
            $table->string('pengolah_surat')->nullable();
            $table->string('no_surat', 50)->nullable();
            $table->string('perihal', length: 50)->nullable();
            $table->string('lain_lain', length: 100)->nullable();
            $table->string('file_surat', 100)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('surat_keluars');
    }
};
