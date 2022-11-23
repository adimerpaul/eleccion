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
        Schema::create('predilectas', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('conjuto');
            $table->string('edad');
            $table->string('profesion');
            $table->string('ocupacion');
            $table->string('estatura');
            $table->string('medidas');
            $table->string('pasatiempo');
            $table->string('color');
            $table->string('deporte');
            $table->string('foto1');
            $table->string('foto2');
            $table->string('foto3');
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
        Schema::dropIfExists('predilectas');
    }
};
