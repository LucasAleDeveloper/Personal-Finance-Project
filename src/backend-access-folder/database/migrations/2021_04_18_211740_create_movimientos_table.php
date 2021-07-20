<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMovimientosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('movimientos', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string("nombre");
            $table->string("descripcion");
            $table->integer("user");
            $table->float("monto");
            $table->unsignedBigInteger("tipo");
            $table->foreign("tipo")->references("id")->on("tipo_movimiento")->on_delete('cascade');
            $table->unsignedBigInteger("categoria");
            $table->foreign("categoria")->references("id")->on("categorias")->on_delete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        /* Schema::dropIfExists('tipo_movimiento');
        Schema::dropIfExists('categorias'); */
        Schema::dropIfExists('movimientos');
    }
}
