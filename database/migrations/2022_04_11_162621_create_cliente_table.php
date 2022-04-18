<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClienteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cliente', function (Blueprint $table) {
            $table->id();
            $table->string('tipo_documento', 10);
            $table->string('numero_documento', 20)->unique();
            $table->string('nombre', 25);
            $table->string('apellido', 25);
            $table->string('tipo_cliente', 30) ->comment('Persona natural o Juridica');
            $table->string('razon_social', 30) ->nullable();
            $table->string('nit', 30)   ->nullable();
            $table->string('correo', 255)->unique();
            $table->string('celular', 15);
            $table->string('direccion', 30);
            $table->string('departamento', 30);
            $table->string('municipio', 30);
            $table->date('fecha_nacimiento')    ->nullable();
            $table->integer('edad')             ->nullable();
            $table->unsignedBigInteger('id_p_ocupacion')     ->nullable();
            $table->string('foto', 255)         ->nullable();
            $table->unsignedBigInteger('id_p_eps')->nullable();
            $table->dateTime('fecha_creacion');
            $table->timestamps();

            $table->foreign('id_p_eps')->references('id')->on('p_eps');
            $table->foreign('id_p_ocupacion')->references('id')->on('p_ocupacion');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cliente');
    }
}
