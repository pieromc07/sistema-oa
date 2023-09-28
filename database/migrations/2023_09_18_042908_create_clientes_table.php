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
        Schema::create('clientes', function (Blueprint $table) {
            $table->increments('cli_id');
            $table->string('cli_apellido_paterno');
            $table->string('cli_apellido_materno');
            $table->string('cli_nombres');
            $table->unsignedInteger('tdo_id');
            $table->string('cli_numero_documento');
            $table->string('cli_direccion')->nullable();
            $table->string('cli_celular')->nullable();
            $table->unsignedInteger('dis_id');
            $table->foreign('dis_id')->references('dis_id')->on('distritos');
            $table->foreign('tdo_id')->references('tdo_id')->on('tipo_documentos');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clientes');
    }
};
