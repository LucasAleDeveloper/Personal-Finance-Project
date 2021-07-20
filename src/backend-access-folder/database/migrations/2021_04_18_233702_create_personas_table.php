<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePersonasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('personas', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string("nombre")->nullable();
            $table->string("apellido")->nullable();
            $table->string("empresa")->nullable();
            $table->unsignedBigInteger("usuario_creador");
            $table->foreign("usuario_creador")->references('id')->on('users')->on_delete('cascade');
            $table->string("url_foto")->nullable();
            $table->string("telefono")->nullable();
            $table->string("email")->nullable();
            $table->string("direccion")->nullable();
            $table->string("Pais")->nullable();
            $table->string("Provincia_estado")->nullable();
            $table->string("Ciudad")->nullable();
            $table->string("CUIL_CUIT")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {/* 
        Schema::dropIfExists('users'); */
        Schema::dropIfExists('personas');
    }
}
