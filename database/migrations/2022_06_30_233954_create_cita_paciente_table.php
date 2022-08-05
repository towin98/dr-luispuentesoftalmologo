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
            $table->unsignedBigInteger('id_paciente')           ->comment('Id Paciente');
            $table->string('tipo_consulta')                     ->comment('Tipo de consulta cita');
            $table->date('fecha_cita');
            $table->time('hora_cita');
            $table->string('observacion',255)       ->nullable();
            $table->string('asistio', 2)            ->nullable()->comment('Asistio paciente cita, SI o NO');
            $table->unsignedBigInteger('id_alerta_cita') ->nullable()->comment('Id notificacion cita');
            $table->string('prioridad', 2)          ->nullable()->comment('Prioridad asistir cita, SI o NO');
            $table->dateTime('prioridad_aceptado')      ->nullable()->comment('Prioridad aceptada');
            $table->timestamps();

            $table->foreign('id_paciente')->references('id')->on('paciente');
            $table->foreign('id_alerta_cita')->references('id')->on('alerta_cita');
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
