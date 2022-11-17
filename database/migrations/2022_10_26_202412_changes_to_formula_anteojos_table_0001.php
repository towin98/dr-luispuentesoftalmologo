<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ChangesToFormulaAnteojosTable0001 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Campos Fondo de Ojo ojo derecho
        DB::statement("ALTER TABLE formula_anteojos MODIFY fon_od_pap TEXT NOT NULL COMMENT \"Fondo de ojo derecho papila\"");
        DB::statement("ALTER TABLE formula_anteojos MODIFY fon_od_vit TEXT NOT NULL COMMENT \"Fondo de ojo derecho vitreo\"");
        DB::statement("ALTER TABLE formula_anteojos MODIFY fon_od_mac TEXT NOT NULL COMMENT \"Fondo de ojo derecho macula\"");
        DB::statement("ALTER TABLE formula_anteojos MODIFY fon_od_per TEXT NOT NULL COMMENT \"Fondo de ojo derecho periferia\"");
        DB::statement("ALTER TABLE formula_anteojos MODIFY fon_od_vre TEXT NOT NULL COMMENT \"Fondo de ojo derecho Vasos Retinales\"");
        DB::statement("ALTER TABLE formula_anteojos MODIFY fon_od_retina TEXT NOT NULL COMMENT \"Fondo de ojo derecho retina\"");

        // Campos Fondo de Ojo ojo izquierdo
        DB::statement("ALTER TABLE formula_anteojos MODIFY fon_oi_pap TEXT NOT NULL COMMENT \"Fondo de ojo izquierdo papila\"");
        DB::statement("ALTER TABLE formula_anteojos MODIFY fon_oi_vit TEXT NOT NULL COMMENT \"Fondo de ojo izquierdo vitreo\"");
        DB::statement("ALTER TABLE formula_anteojos MODIFY fon_oi_mac TEXT NOT NULL COMMENT \"Fondo de ojo izquierdo macula\"");
        DB::statement("ALTER TABLE formula_anteojos MODIFY fon_oi_per TEXT NOT NULL COMMENT \"Fondo de ojo izquierdo periferia\"");
        DB::statement("ALTER TABLE formula_anteojos MODIFY fon_oi_vre TEXT NOT NULL COMMENT \"Fondo de ojo izquierdo Vasos Retinales\"");
        DB::statement("ALTER TABLE formula_anteojos MODIFY fon_oi_retina TEXT NOT NULL COMMENT \"Fondo de ojo izquierdo retina\"");

        // Examen Oftalmológico
        DB::statement("ALTER TABLE formula_anteojos MODIFY ppc              TEXT NOT NULL COMMENT \"Punto Próximo de Convergencia\"");
        DB::statement("ALTER TABLE formula_anteojos MODIFY motilidad_ocular TEXT NOT NULL COMMENT \"Motilidad ocular\"");
        DB::statement("ALTER TABLE formula_anteojos MODIFY hirschberg       TEXT NOT NULL COMMENT \"hirschberg\"");
        DB::statement("ALTER TABLE formula_anteojos MODIFY cover_test       TEXT NOT NULL COMMENT \"Cover Test\"");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Se deja el mismo tipo de campo, porque al regresarlos a varchar (30) genera error.
        // Ademas no es muy necesario regresarlos al mismo tipo de campo
    }
}
