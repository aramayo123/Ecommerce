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
        Schema::create('productos', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_categoria')->unsigned();
            $table->foreign('id_categoria')->references('id')->on('categorias')->onDelete('cascade');
            $table->string('titulo');
            $table->string('foto_1');
            $table->string('foto_2');
            $table->string('foto_3');
            $table->string('caracteristicas');
            $table->bigInteger('users_compras')->nullable();
            $table->bigInteger('cantidad')->nullable();
            $table->float('precio');
            $table->float('precio_envio');
            $table->unsignedBigInteger('active');
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
        Schema::dropIfExists('productos');
    }
};
