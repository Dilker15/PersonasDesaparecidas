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
        Schema::create('enfermedades_denuncia', function (Blueprint $table) {
            $table->id();
            $table->foreignId('enfermedad_id')->constrained(table:'enfermedades')->nullable();
            $table->foreignId('denuncia_id')->constrained(table:'denuncias')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('enfermedades_denuncia');
    }
};
