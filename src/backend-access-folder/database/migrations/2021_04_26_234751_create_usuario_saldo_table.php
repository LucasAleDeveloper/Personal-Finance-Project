<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsuarioSaldoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('usuario_saldo', function (Blueprint $table) {
            $table->timestamps();
            $table->unsignedBigInteger('usuario');
            $table->foreign('usuario')->references('id')->on('users')->on_delete('cascade');
            $table->float('saldo');
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
        Schema::dropIfExists('usuario_saldo');
    }
}
