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
            $table->string('correo', 255)->default('');
            $table->string('celular', 15)->default('');
            $table->string('direccion', 30)->default('');
            $table->string('departamento', 30)->default('');
            $table->string('municipio', 30)->default('');
            $table->date('fecha_nacimiento')->nullable();
            $table->string('edad',3)->default('');
            $table->string('ocupacion', 100)->default('');
            $table->string('foto')->default('');
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
