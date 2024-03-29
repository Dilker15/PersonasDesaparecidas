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
        Schema::create('avistamientos', function (Blueprint $table) {
            $table->id();
            $table->string('descripcion')->nullable();
            $table->string('ubicacion')->nullable();
            $table->time('hora');
            $table->date('fecha');
            $table->string('contacto');
            $table->foreignId('denuncia_id')->constrained(table:'denuncias')->nullable();
            $table->foreignId('user_id')->constrained(table:'users')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('avistamientos');
    }
};
