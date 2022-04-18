<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePOcupacionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('p_ocupacion', function (Blueprint $table) {
            $table->id();
            $table->string('codigo',25)->unique() ->comment('Codigo de la ocupacion');
            $table->string('descripcion',255) ->comment('Descripcion de la ocupacion');
            $table->string('estado') ->comment('Estado en que se encuentra la ocupacion');
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
        Schema::dropIfExists('p_ocupacion');
    }
}
