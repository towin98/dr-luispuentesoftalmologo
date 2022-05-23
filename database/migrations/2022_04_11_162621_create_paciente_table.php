<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePacienteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('paciente', function (Blueprint $table) {
            $table->id();
            $table->string('tipo_documento', 10);
            $table->string('numero_documento', 20)->unique();
            $table->string('nombre', 25);
            $table->string('apellido', 25);
            $table->string('correo', 255)->unique();
            $table->string('celular', 15);
            $table->string('direccion', 30);
            $table->string('departamento', 30);
            $table->string('municipio', 30);
            $table->date('fecha_nacimiento');
            $table->integer('edad');
            $table->string('ocupacion', 100);
            $table->string('foto') ->nullable();
            $table->unsignedBigInteger('id_p_eps');
            $table->dateTime('fecha_creacion');
            $table->timestamps();

            $table->foreign('id_p_eps')->references('id')->on('p_eps');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('paciente');
    }
}
