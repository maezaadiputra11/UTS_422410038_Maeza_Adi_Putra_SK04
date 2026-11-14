<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kondisi_awals', function (Blueprint $table) {
            $table->id();
            // One-to-One: FK dibuat unique agar satu koleksi hanya punya satu detail kondisi.
            // cascadeOnDelete: detail ikut terhapus jika koleksi dihapus.
            $table->foreignId('koleksi_pita_id')
                ->unique()
                ->constrained('koleksi_pitas')
                ->cascadeOnDelete();
            $table->enum('tingkat_kerusakan', ['ringan', 'sedang', 'berat'])->default('ringan');
            $table->boolean('ada_jamur')->default(false);
            $table->boolean('sticky_shed')->default(false);
            $table->date('tanggal_periksa')->nullable();
            $table->text('catatan')->nullable();
            $table->timestamps();

            $table->index('tingkat_kerusakan');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kondisi_awals');
    }
};
