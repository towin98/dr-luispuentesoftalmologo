<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCitaPacienteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cita_paciente', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_paciente')->comment('Id Paciente');
            $table->string('tipo_consulta')          ->comment('Tipo de consulta cita');
            $table->date('fecha_cita');
            $table->time('hora_cita');
            $table->string('observacion',255)->nullable();
            $table->timestamps();

            $table->foreign('id_paciente')->references('id')->on('paciente');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cita_paciente');
    }
}
