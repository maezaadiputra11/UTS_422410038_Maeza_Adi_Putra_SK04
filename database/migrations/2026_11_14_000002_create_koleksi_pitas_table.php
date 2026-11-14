<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('koleksi_pitas', function (Blueprint $table) {
            $table->id();
            // One-to-Many: satu format media punya banyak koleksi.
            // restrictOnDelete: format yang masih dipakai koleksi tidak boleh dihapus.
            $table->foreignId('format_media_id')
                ->constrained('format_media')
                ->restrictOnDelete();
            $table->string('kode', 20)->unique();
            $table->string('nama', 150);
            $table->unsignedSmallInteger('tahun_rekaman')->nullable();
            $table->text('deskripsi')->nullable();
            $table->timestamps();

            $table->index('nama');
            $table->index(['format_media_id', 'nama']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('koleksi_pitas');
    }
};
