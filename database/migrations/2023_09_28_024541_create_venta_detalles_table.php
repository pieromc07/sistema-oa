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
        Schema::create('venta_detalles', function (Blueprint $table) {
            $table->increments('vde_id');
            $table->integer('ven_id')->unsigned();
            $table->integer('pro_id')->unsigned();
            $table->integer('vde_cantidad');
            $table->decimal('vde_precio', 10, 2)->default(0);
            $table->decimal('vde_subtotal', 10, 2)->default(0);
            $table->decimal('vde_impuesto', 10, 2)->default(0);
            $table->foreign('ven_id')->references('ven_id')->on('ventas');
            $table->foreign('pro_id')->references('pro_id')->on('productos');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('venta_detalles');
    }
};
