<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEvolucionHcTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('evolucion_hc', function (Blueprint $table) {
            $table->id('evo_id');
            $table->unsignedBigInteger('evo_id_paciente')->comment('Id Paciente');
            $table->unsignedBigInteger('evo_id_historia_clinica')->comment('Id de Historia Clinica');
            $table->string('evo_consecutivo', 6)->comment('Consecutivo evolucion');
            $table->date('evo_fecha_diligenciamiento')->comment('Fecha de diligenciamiento evolucion');
            $table->text('evo_descripcion_evolucion')->comment('Descripcion Evolucion');
            $table->text('evo_tratamiento')->comment('Descripcion de tratamiento');
            $table->text('evo_orden_medica')->comment('Descripcion de orden medica');
            $table->timestamps();

            $table->foreign('evo_id_paciente')->references('id')->on('paciente');
            $table->foreign('evo_id_historia_clinica')->references('id')->on('formula_anteojos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('evolucion_hc');
    }
}
