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
        Schema::create('denuncias', function (Blueprint $table) {
            $table->id();
            $table->String('nombre');
            $table->String('apellidos');
            $table->unsignedSmallInteger('genero');
            $table->date('fecha_nacimiento');
            $table->String('altura',10);
            $table->String('peso',10);
            $table->String('cicatriz');
            $table->String('tatuaje');
            $table->String('direccion');
            $table->smallInteger('color_cabello');
            $table->smallInteger('color_ojos');
            $table->date('fecha_desaparicion');
            $table->time('hora_desaparicion');
            $table->String('ultima_ropa_puesta');
            $table->String('ubicacion');
            $table->foreignId('user_id')->constrained(table:'users')->nullable();
            $table->foreignId('nacionalidad_id')->constrained(table:'nacionalidades')->nullable();
            $table->foreignId('documento_id')->constrained(table:'documentos')->nullable();
            $table->foreignId('idioma_id')->constrained(table:'idiomas')->nullable();
            $table->string('contacto')->nullable();
            $table->unsignedSmallInteger('estado')->default(1);
            $table->timestamps();
        });
    }

    /**c
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('denuncias');
    }
};
