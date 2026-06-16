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
        Schema::create('fotos', function (Blueprint $table) {
            $table->id('foto_id'); // Llave primaria personalizada
            $table->string('foto_nombre');
            $table->text('foto_descripcion');
            $table->string('foto_ruta');
            
            // Relación con la tabla 'albums', indicando que la llave primaria de referencia es 'album_id'
            $table->foreignId('album_id')->constrained('albums', 'album_id')->onDelete('cascade');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fotos');
    }
};
