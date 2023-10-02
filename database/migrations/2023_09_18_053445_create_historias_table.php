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
        Schema::create('historias', function (Blueprint $table) {
            $table->increments('his_id');
            $table->integer('cli_id')->unsigned();
            $table->integer('usu_id')->unsigned();
            $table->date('his_fecha');
            $table->string('his_descripcion', 100)->nullable();
            $table->string('his_antencedentes', 100)->nullable();
            $table->string('his_add', 100)->nullable();
            $table->string('his_od', 100)->nullable();
            $table->string('his_oi', 100)->nullable();
            $table->string('his_lentesContacto', 100)->nullable();
            $table->date('his_fechaProxRevision')->nullable();
            $table->foreign('cli_id')->references('cli_id')->on('clientes');
            $table->foreign('usu_id')->references('usu_id')->on('usuarios');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('historias');
    }
};
