<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Pivot Many-to-Many: koleksi <-> tindakan restorasi (rencana tindakan).
        Schema::create('koleksi_tindakan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('koleksi_pita_id')
                ->constrained('koleksi_pitas')
                ->cascadeOnDelete();
            $table->foreignId('tindakan_restorasi_id')
                ->constrained('tindakan_restorasis')
                ->restrictOnDelete();
            $table->unsignedTinyInteger('prioritas')->default(3);
            $table->enum('status', ['rencana', 'berjalan', 'selesai'])->default('rencana');
            $table->timestamps();

            // Mencegah tindakan yang sama dipilih dua kali pada koleksi yang sama.
            $table->unique(['koleksi_pita_id', 'tindakan_restorasi_id'], 'koleksi_tindakan_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('koleksi_tindakan');
    }
};
