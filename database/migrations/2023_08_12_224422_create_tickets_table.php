<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->string('id_mercadopago')->nullable();
            $table->string('url_payment')->nullable();
            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->bigInteger('contacto');
            $table->string('direccion')->nullable();
            $table->bigInteger('total_precio');
            $table->string('ciudad')->nullable();
            $table->string('provincia')->nullable();
            $table->string('codigo_postal')->nullable();
            $table->string('pais')->nullable();
            $table->boolean('bool_pagado')->default(0);
            $table->boolean('bool_acreditado')->default(0);
            $table->boolean('bool_cancelado')->default(0);
            $table->string('estado')->nullable();
            $table->string('estado_detallado')->nullable();
            $table->string('fecha_creacion')->nullable();
            $table->string('hora_creacion')->nullable();
            $table->string('fecha_del_pago')->nullable();
            $table->string('hora_del_pago')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tickets');
    }
};
