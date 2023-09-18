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
        Schema::create('colaboradores', function (Blueprint $table) {
            $table->increments('col_id');
            $table->string('col_apellido_paterno');
            $table->string('col_apellido_materno');
            $table->string('col_nombres');
            $table->unsignedInteger('tdo_id');
            $table->string('col_numero_documento');
            $table->string('col_direccion')->nullable();
            $table->string('col_celular')->nullable();
            $table->unsignedInteger('pue_id');
            $table->boolean('col_isOptometra')->default(false);
            $table->unsignedInteger('dis_id');
            $table->foreign('dis_id')->references('dis_id')->on('distritos');
            $table->foreign('tdo_id')->references('tdo_id')->on('tipo_documentos');
            $table->foreign('pue_id')->references('pue_id')->on('puestos');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('colaboradores');
    }
};
