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
        Schema::create('citas', function (Blueprint $table) {
            $table->increments('cit_id');
            $table->integer('cli_id')->unsigned();
            $table->integer('col_id')->unsigned();
            $table->integer('hor_id')->unsigned();
            $table->date('cit_fecha');
            $table->boolean('cit_estado');
            $table->foreign('cli_id')->references('cli_id')->on('clientes');
            $table->foreign('col_id')->references('col_id')->on('colaboradores');
            $table->foreign('hor_id')->references('hor_id')->on('horarios');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('citas');
    }
};
