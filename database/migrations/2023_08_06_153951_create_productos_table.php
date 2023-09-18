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
            $table->increments('pro_id');
            $table->string('pro_nombre');
            $table->string('pro_descripcion')->nullable();
            $table->decimal('pro_stock', 8, 2);
            $table->decimal('pro_stock_minimo', 8, 2);
            $table->string('pro_codigo_barra');
            $table->decimal('pro_precio_venta', 8, 2);
            $table->decimal('pro_precio_compra', 8, 2);
            $table->date('pro_fecha_vencimiento')->nullable();
            $table->unsignedInteger('cat_id');
            $table->unsignedInteger('mar_id');
            $table->foreign('cat_id')->references('cat_id')->on('categorias');
            $table->foreign('mar_id')->references('mar_id')->on('marcas');
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
