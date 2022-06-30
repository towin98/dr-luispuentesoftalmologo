<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCargarArchivosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cargar_archivos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_paciente')   ->comment('Id Paciente');
            $table->text('ruta_archivo')                ->comment('Nombre archivo cargado');
            $table->string('consecutivo_archivo',5)     ->comment('Consecutivo de archivo cargado para el paciente');
            $table->string('observacion')->nullable()   ->comment('Observacion');
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
        Schema::dropIfExists('cargar_archivos');
    }
}
