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
            $table->string('avs_cc_od', 25)->comment('Agudeza Visual con correccion ojo derecho');
            $table->string('avs_cc_oi', 25)->comment('Agudeza Visual con correccion ojo izquierdo');

            // Campos AVS SC
            $table->string('avs_sc_od', 25)->comment('Agudeza Visual sin correccion ojo derecho');
            $table->string('avs_sc_oi', 25)->comment('Agudeza Visual sin correccion ojo izquierdo');

            // Campos RX
            $table->string('rx_od', 25)->comment('RX ojo derecho');
            $table->string('rx_oi', 25)->comment('RX ojo izquierdo');
            $table->string('adicion', 25)->comment('adicion');
            $table->string('dp', 25)->comment('Distancia Pupilar');
            $table->text('observacion')->comment('Observacion');

            // Campos Refraccion Objetiva
            $table->string('ref_obj_od', 25)->comment('Refraccion Objetiva ojo derecho');
            $table->string('ref_obj_oi', 25)->comment('Refraccion Objetiva ojo izquierdo');

            // Campos Refraccion Subjetiva
            $table->string('ref_sub_od', 25)->comment('Refraccion Subjetiva ojo derecho');
            $table->string('ref_sub_oi', 25)->comment('Refraccion Subjetiva ojo izquierdo');

            // Campos Queratometria
            $table->string('que_od', 25)->comment('Queratometria ojo derecho');
            $table->string('que_oi', 25)->comment('Queratometria ojo izquierdo');
            $table->string('hirschberg', 25)->comment('hirschberg');
            $table->string('cover_test', 25)->comment('Cover Test');
            $table->string('ppc', 25)->comment('Punto Próximo de Convergencia');
            $table->string('motilidad_ocular', 25)->comment('Motilidad ocular');
            $table->string('dilatacion_pupilar', 25)->comment('Dilatacion pupilar');
            $table->string('papilas', 25)->comment('Papilas');

            // Campos Biomicroscopia ojo derecho
            $table->string('bio_od_par', 25)->comment('Biomicroscopia ojo derecho parpados');
            $table->string('bio_od_ang', 25)->comment('Biomicroscopia ojo derecho angulo');
            $table->string('bio_od_cri', 25)->comment('Biomicroscopia ojo derecho cristalino');
            $table->string('bio_od_con', 25)->comment('Biomicroscopia ojo derecho conjuntiva');
            $table->string('bio_od_iris', 25)->comment('Biomicroscopia ojo derecho iris');
            $table->string('bio_od_pro', 25)->comment('Biomicroscopia ojo derecho presion Ocular');
            $table->string('bio_od_cor', 25)->comment('Biomicroscopia ojo derecho cornea');
            $table->string('bio_od_rpa', 25)->comment('Biomicroscopia ojo derecho Reflejo Papilar');

            // Campos Biomicroscopia ojo izquierdo
            $table->string('bio_oi_par', 25)->comment('Biomicroscopia ojo izquierdo parpados');
            $table->string('bio_oi_ang', 25)->comment('Biomicroscopia ojo izquierdo angulo');
            $table->string('bio_oi_cri', 25)->comment('Biomicroscopia ojo izquierdo cristalino');
            $table->string('bio_oi_con', 25)->comment('Biomicroscopia ojo izquierdo conjuntiva');
            $table->string('bio_oi_iris', 25)->comment('Biomicroscopia ojo izquierdo iris');
            $table->string('bio_oi_pro', 25)->comment('Biomicroscopia ojo izquierdo presion Ocular');
            $table->string('bio_oi_cor', 25)->comment('Biomicroscopia ojo izquierdo cornea');
            $table->string('bio_oi_rpa', 25)->comment('Biomicroscopia ojo izquierdo Reflejo Papilar');

            // Campos Fondo de Ojo ojo derecho
            $table->string('fon_od_pap', 25)->comment('Fondo de ojo derecho papila');
            $table->string('fon_od_vit', 25)->comment('Fondo de ojo derecho vitreo');
            $table->string('fon_od_mac', 25)->comment('Fondo de ojo derecho macula');
            $table->string('fon_od_per', 25)->comment('Fondo de ojo derecho periferia');
            $table->string('fon_od_vre', 25)->comment('Fondo de ojo derecho Vasos Retinales');
            $table->string('fon_od_retina', 25)->comment('Fondo de ojo derecho retina');

            // Campos Fondo de Ojo ojo izquierdo
            $table->string('fon_oi_pap', 25)->comment('Fondo de ojo izquierdo papila');
            $table->string('fon_oi_vit', 25)->comment('Fondo de ojo izquierdo vitreo');
            $table->string('fon_oi_mac', 25)->comment('Fondo de ojo izquierdo macula');
            $table->string('fon_oi_per', 25)->comment('Fondo de ojo izquierdo periferia');
            $table->string('fon_oi_vre', 25)->comment('Fondo de ojo izquierdo Vasos Retinales');
            $table->string('fon_oi_retina', 25)->comment('Fondo de ojo izquierdo retina');

            // Diagnostico
            $table->text('diagnostico')->comment('Diagnostico');

            // Tratamiento
            $table->text('tratamiento')->comment('Tratamiento');

            // Tratamiento
            $table->text('orden_medica')->comment('Orden Medica');

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
