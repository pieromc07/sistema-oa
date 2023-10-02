<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('ventas', function (Blueprint $table) {
            $table->increments('ven_id');
            $table->integer('cli_id')->unsigned();
            $table->integer('usu_id')->unsigned();
            $table->integer('met_id')->unsigned();
            $table->date('ven_fecha');
            $table->decimal('ven_total', 10, 2)->default(0);
            $table->decimal('ven_subtotal', 10, 2)->default(0);
            $table->decimal('ven_impuesto', 10, 2)->default(0);
            $table->string('ven_serie', 3);
            $table->string('ven_numero', 10);
            $table->boolean('ven_estado')->default(1);
            $table->foreign('cli_id')->references('cli_id')->on('clientes');
            $table->foreign('usu_id')->references('usu_id')->on('usuarios');
            $table->foreign('met_id')->references('met_id')->on('metodo_pagos');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ventas');
    }
};
