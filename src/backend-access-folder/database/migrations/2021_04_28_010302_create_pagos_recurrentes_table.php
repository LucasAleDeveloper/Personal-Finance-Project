<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePagosRecurrentesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pagos_recurrentes', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId("categoria")->references("id")->on("categorias")->on_delete('cascade');
            $table->foreignId("user_id")->references("id")->on("users")->on_delete('cascade');
            $table->string("titulo");
            $table->string("descripcion");
            $table->float("monto");
            $table->dateTime("vencimiento");
            $table->dateTime("ultima_fecha_pago");
            $table->dateTime("intervalo_repeticion");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        /* Schema::dropIfExists('users');
        Schema::dropIfExists('categorias'); */
        Schema::dropIfExists('pagos_recurrentes');
    }
}
