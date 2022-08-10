<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAlertaCitaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('alerta_cita', function (Blueprint $table) {
            $table->id()                                           ->comment('Id de alerta');
            $table->string('tipo_alerta')                          ->comment('Tipo de alerta');
            $table->dateTime('leido')->nullable()                  ->comment('Notificacion leida');
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
        Schema::dropIfExists('alerta_cita');
    }
}
