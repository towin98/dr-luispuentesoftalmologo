<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFormulaAnteojosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('formula_anteojos', function (Blueprint $table) {
            $table->id('id');
            $table->unsignedBigInteger('id_paciente')->comment('Id Paciente');
            $table->string('numero_formula_anteojos', 6)->comment('Numero formula anteojos consecutivo');

            // Campos AVS CC
            $table->string('avs_cc_od', 30)->default('')->comment('Agudeza Visual con correccion ojo derecho');
            $table->string('avs_cc_oi', 30)->default('')->comment('Agudeza Visual con correccion ojo izquierdo');

            // Campos AVS SC
            $table->string('avs_sc_od', 30)->default('')->comment('Agudeza Visual sin correccion ojo derecho');
            $table->string('avs_sc_oi', 30)->default('')->comment('Agudeza Visual sin correccion ojo izquierdo');

            // Campos RX
            $table->string('rx_od', 30)->default('')->comment('RX ojo derecho');
            $table->string('rx_oi', 30)->default('')->comment('RX ojo izquierdo');
            $table->string('adicion', 30)->default('')->comment('adicion');
            $table->string('dp', 30)->default('')->comment('Distancia Pupilar');
            $table->text('observacion')->comment('Observacion');

            // Campos Refraccion Subjetiva
            $table->string('ref_sub_od', 30)->default('')->comment('Refraccion Subjetiva ojo derecho');
            $table->string('ref_sub_oi', 30)->default('')->comment('Refraccion Subjetiva ojo izquierdo');

            // Campos Queratometria
            $table->string('que_od', 30)                ->default('')->comment('Queratometria ojo derecho');
            $table->string('que_oi', 30)                ->default('')->comment('Queratometria ojo izquierdo');
            $table->string('hirschberg', 30)            ->default('')->comment('hirschberg');
            $table->string('cover_test', 30)            ->default('')->comment('Cover Test');
            $table->string('ppc', 30)                   ->default('')->comment('Punto Próximo de Convergencia');
            $table->string('motilidad_ocular', 30)      ->default('')->comment('Motilidad ocular');

            // Campos Biomicroscopia ojo derecho
            $table->text('bio_od_par')->comment('Biomicroscopia ojo derecho parpados');
            $table->text('bio_od_ang')->comment('Biomicroscopia ojo derecho angulo');
            $table->text('bio_od_cri')->comment('Biomicroscopia ojo derecho cristalino');
            $table->text('bio_od_con')->comment('Biomicroscopia ojo derecho conjuntiva');
            $table->text('bio_od_iris')->comment('Biomicroscopia ojo derecho iris');
            $table->text('bio_od_pro')->comment('Biomicroscopia ojo derecho presion Ocular');
            $table->text('bio_od_cor')->comment('Biomicroscopia ojo derecho cornea');
            $table->text('bio_od_rpu')->comment('Biomicroscopia ojo derecho Reflejo Pupilar');
            $table->text('bio_od_dil')->comment('Biomicroscopia ojo derecho Dilatacion');

            // Campos Biomicroscopia ojo izquierdo
            $table->text('bio_oi_par')->comment('Biomicroscopia ojo izquierdo parpados');
            $table->text('bio_oi_ang')->comment('Biomicroscopia ojo izquierdo angulo');
            $table->text('bio_oi_cri')->comment('Biomicroscopia ojo izquierdo cristalino');
            $table->text('bio_oi_con')->comment('Biomicroscopia ojo izquierdo conjuntiva');
            $table->text('bio_oi_iris')->comment('Biomicroscopia ojo izquierdo iris');
            $table->text('bio_oi_pro')->comment('Biomicroscopia ojo izquierdo presion Ocular');
            $table->text('bio_oi_cor')->comment('Biomicroscopia ojo izquierdo cornea');
            $table->text('bio_oi_rpu')->comment('Biomicroscopia ojo izquierdo Reflejo Pupilar');
            $table->text('bio_oi_dil')->comment('Biomicroscopia ojo izquierdo Dilatacion');

            // Campos Fondo de Ojo ojo derecho
            $table->string('fon_od_pap', 30)->default('')->comment('Fondo de ojo derecho papila');
            $table->string('fon_od_vit', 30)->default('')->comment('Fondo de ojo derecho vitreo');
            $table->string('fon_od_mac', 30)->default('')->comment('Fondo de ojo derecho macula');
            $table->string('fon_od_per', 30)->default('')->comment('Fondo de ojo derecho periferia');
            $table->string('fon_od_vre', 30)->default('')->comment('Fondo de ojo derecho Vasos Retinales');
            $table->string('fon_od_retina', 30)->default('')->comment('Fondo de ojo derecho retina');

            // Campos Fondo de Ojo ojo izquierdo
            $table->string('fon_oi_pap', 30)->default('')->comment('Fondo de ojo izquierdo papila');
            $table->string('fon_oi_vit', 30)->default('')->comment('Fondo de ojo izquierdo vitreo');
            $table->string('fon_oi_mac', 30)->default('')->comment('Fondo de ojo izquierdo macula');
            $table->string('fon_oi_per', 30)->default('')->comment('Fondo de ojo izquierdo periferia');
            $table->string('fon_oi_vre', 30)->default('')->comment('Fondo de ojo izquierdo Vasos Retinales');
            $table->string('fon_oi_retina', 30)->default('')->comment('Fondo de ojo izquierdo retina');

            // Diagnostico
            $table->text('diagnostico')->comment('Diagnostico');

            // Tratamiento
            $table->text('tratamiento')->comment('Tratamiento');

            // Tratamiento
            $table->text('orden_medica')->comment('Orden Medica');

            // Observaciones 2
            $table->text('observaciones2')->comment('Observaciones2');

            $table->date('fecha_formula')->comment('Fecha Formula');
            $table->softDeletes();
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
        Schema::dropIfExists('formula_anteojos');
    }
}
