<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ChangesToMotivoConsultaTable0001 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('motivo_consulta', function (Blueprint $table) {
            $table->renameColumn('numero_evolucion', 'mc_consecutivo');
            $table->dropColumn([
                'fecha',
                'hora'
            ]);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('motivo_consulta', function (Blueprint $table) {
            $table->renameColumn('mc_consecutivo', 'numero_evolucion');
            $table->date('fecha')->nullable()->after('url_refraccion');
            $table->time('hora')->nullable()->after('fecha');
        });
    }
}
