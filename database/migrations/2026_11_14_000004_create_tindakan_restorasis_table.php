<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tindakan_restorasis', function (Blueprint $table) {
            $table->id();
            $table->string('nama', 120)->unique();
            $table->text('deskripsi')->nullable();
            $table->unsignedSmallInteger('estimasi_jam')->default(1);
            $table->boolean('aktif')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tindakan_restorasis');
    }
};
