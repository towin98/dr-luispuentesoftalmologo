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
            $table->string('correo', 255)->nullable();
            $table->string('celular', 15)->nullable();
            $table->string('direccion', 30)->nullable();
            $table->string('departamento', 30)->nullable();
            $table->string('municipio', 30)->nullable();
            $table->date('fecha_nacimiento')->nullable();
            $table->integer('edad')->nullable();
            $table->string('ocupacion', 100)->nullable();
            $table->string('foto') ->nullable()->nullable();
            $table->unsignedBigInteger('id_p_eps');
            $table->dateTime('fecha_creacion');
            $table->softDeletes();
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
