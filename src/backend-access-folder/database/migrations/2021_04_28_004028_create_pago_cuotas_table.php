<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePagoCuotasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pago_cuotas', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->integer("cantidad_cuotas");
            $table->float("monto_cuotas");
            $table->integer("cantidad_cuotas_pagas");
            $table->foreignId("movimiento_id")->references('id')->on('movimientos')->on_delete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {/* 
        Schema::dropIfExists('movimientos'); */
        Schema::dropIfExists('pago_cuotas');
    }
}
