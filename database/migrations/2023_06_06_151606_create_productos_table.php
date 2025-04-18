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
        Schema::create('productos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('descripcion');
            $table->unsignedBigInteger('id_propietario')->nullable();
            $table->foreign('id_propietario')->references('id')->on('users');
            $table->decimal('precio', 8, 2);
            $table->string('imagen1')->nullable();
            $table->string('imagen2')->nullable();
            $table->string('imagen3')->nullable();
            $table->string('imagen4')->nullable();
            $table->string('video')->nullable();
            $table->integer('stock')->default(0);
            $table->integer('stock_min')->nullable();
            $table->string('archivo_3d')->nullable();
            $table->string('descripcion_3d')->nullable();
            $table->string('zip_path')->nullable();
            $table->boolean('es_3d')->default(false);
            $table->decimal('precio_3d', 8, 2)->nullable();
            $table->boolean('es_formato_obj')->default(false);
            $table->boolean('es_formato_gltf')->default(false);
            $table->boolean('es_formato_fbx')->default(false);
            $table->boolean('es_formato_stl')->default(false);
            $table->unsignedBigInteger('categoria_id');
            $table->foreign('categoria_id')->references('id')->on('categorias');
            $table->unsignedBigInteger('color_id');
            $table->foreign('color_id')->references('id')->on('colors');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('productos');
    }
};
