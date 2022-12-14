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
        Schema::create('votos', function (Blueprint $table) {
            $table->id();
            $table->string('puntaje');
            $table->string('tipo')->default('');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('predilecta_id');
            $table->string('estado')->default('INACTIVO');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('predilecta_id')->references('id')->on('predilectas');
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
        Schema::dropIfExists('votos');
    }
};
