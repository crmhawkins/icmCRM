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
        Schema::create('archivos_piezas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pieza_id');
            $table->string('nombre_archivo', 255);
            $table->string('nombre_original', 255);
            $table->string('ruta_archivo', 500);
            $table->string('extension', 10);
            $table->enum('tipo_archivo', [
                'plano_pdf',
                'plano_daw',
                'plano_dwg',
                'imagen',
                'documento',
                'especificacion',
                'otro'
            ])->default('otro');
            $table->string('version', 20)->nullable();
            $table->text('descripcion')->nullable();
            $table->decimal('tamaño_mb', 10, 2)->nullable();
            $table->string('hash_archivo', 64)->nullable(); // Para verificar integridad
            $table->unsignedBigInteger('usuario_subido_id')->nullable();
            $table->boolean('es_principal')->default(false); // Archivo principal de la pieza
            $table->boolean('activo')->default(true);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('pieza_id')->references('id')->on('piezas')->onDelete('cascade');
            $table->foreign('usuario_subido_id')->references('id')->on('admin_user')->onDelete('set null');

            // Índices
            $table->index(['pieza_id', 'tipo_archivo']);
            $table->index(['tipo_archivo', 'es_principal']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('archivos_piezas');
    }
};
