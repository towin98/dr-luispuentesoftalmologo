<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePEpsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('p_eps', function (Blueprint $table) {
            $table->id();
            $table->string('codigo',25)->unique() ->comment('codigo de la eps prepagada');
            $table->string('descripcion')         ->comment('Descripcion de la eps');
            $table->string('estado',15) ->comment('Estado del registro');
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
        Schema::dropIfExists('p_eps');
    }
}
