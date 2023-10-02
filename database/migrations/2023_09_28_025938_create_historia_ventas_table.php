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
        Schema::create('historia_ventas', function (Blueprint $table) {
            $table->increments('hve_id');
            $table->integer('ven_id')->unsigned();
            $table->integer('his_id')->unsigned();
            $table->foreign('ven_id')->references('ven_id')->on('ventas');
            $table->foreign('his_id')->references('his_id')->on('historias');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('historia_ventas');
    }
};
