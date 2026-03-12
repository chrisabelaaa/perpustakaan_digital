<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('kategoribuku_relasis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('BukuID')->constrained('bukus');
            $table->foreignId('KategoriID')->constrained('kategoribukus');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kategoribuku_relasis');
    }
};
