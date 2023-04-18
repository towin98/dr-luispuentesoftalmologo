<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ChangesToEvolucionHcTable0001 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('evolucion_hc', function (Blueprint $table) {
            $table->text('evo_rx_od')                       ->comment('RX ojo derecho')->after('evo_orden_medica');
            $table->text('evo_rx_oi')                       ->comment('RX ojo izquierdo')->after('evo_rx_od');
            $table->text('evo_adicion')                     ->comment('adicion')->after('evo_rx_oi');
            $table->text('evo_dp')                          ->comment('Distancia Pupilar')->after('evo_adicion');
            $table->text('evo_observacion')                 ->comment('Observacion')->after('evo_dp');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('evolucion_hc', function (Blueprint $table) {
            $table->dropColumn('evo_rx_od');
            $table->dropColumn('evo_rx_oi');
            $table->dropColumn('evo_adicion');
            $table->dropColumn('evo_dp');
            $table->dropColumn('evo_observacion');
        });
    }
}
