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
            $table->string('nombre')->default('');
            $table->string('conjunto')->default('');
            $table->string('edad')->default('');
            $table->string('profesion')->default('');
            $table->string('ocupacion')->default('');
            $table->string('estatura')->default('');
            $table->string('medidas')->default('');
            $table->string('pasatiempo')->default('');
            $table->string('color')->default('');
            $table->string('deporte')->default('');
            $table->string('foto1')->default('avatar.png');
            $table->string('foto2')->default('avatar.png');
            $table->string('foto3')->default('avatar.png');
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
