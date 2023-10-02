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
        Schema::create('historia_lecturas', function (Blueprint $table) {
            $table->increments('hle_id');
            $table->integer('his_id')->unsigned();
            $table->string('hle_distancia', 50)->enum('LEJOS', 'CERCA');
            $table->string('hle_ojo', 50)->enum('DERECHO', 'IZQUIERDO');
            $table->string('hle_esfera', 50);
            $table->string('hle_cilindro', 50);
            $table->string('hle_eje', 50);
            $table->string('hle_av', 50);
            $table->string('hle_dip', 50);
            $table->foreign('his_id')->references('his_id')->on('historias');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('historia_lecturas');
    }
};
