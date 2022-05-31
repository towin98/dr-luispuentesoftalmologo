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
            $table->string('numero_formula_anteojos',6);

            // Campos AVSC
            $table->string('avsc_od', 25)->comment('AVSC ojo derecho');
            $table->string('avsc_oi', 25)->comment('AVSC ojo izquierdo');

            // Campos RX
            $table->string('rx_od', 25)->comment('RX ojo derecho');
            $table->string('rx_oi', 25)->comment('RX ojo izquierdo');

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
            $table->string('motilidad_ocular', 25)->comment('Motilidad ocular ');
            $table->string('dilatacion_pupilar', 25)->comment('Dilatacion pupilar');
            $table->string('pupilas', 25)->comment('Pupilas');

            // Campos Biomicroscopia ojo derecho
            $table->string('bio_od_par', 25)->comment('Biomicroscopia ojo derecho parpados');
            $table->string('bio_od_gra', 25)->comment('Biomicroscopia ojo derecho grado');// PREGUNTAR NOMBRE
            $table->string('bio_od_cri', 25)->comment('Biomicroscopia ojo derecho cristalino');
            $table->string('bio_od_con', 25)->comment('Biomicroscopia ojo derecho conjuntiva');
            $table->string('bio_od_iris', 25)->comment('Biomicroscopia ojo derecho iris');
            $table->string('bio_od_pre', 25)->comment('Biomicroscopia ojo derecho presion');
            $table->string('bio_od_cor', 25)->comment('Biomicroscopia ojo derecho cornea');
            $table->string('bio_od_ref', 25)->comment('Biomicroscopia ojo derecho reflejo');
            $table->string('bio_od_ocu', 25)->comment('Biomicroscopia ojo derecho ocular');
            $table->string('bio_od_pup', 25)->comment('Biomicroscopia ojo derecho pupilar');

            // Campos Biomicroscopia ojo izquierdo
            $table->string('bio_oi_par', 25)->comment('Biomicroscopia ojo izquierdo parpados');
            $table->string('bio_oi_gra', 25)->comment('Biomicroscopia ojo izquierdo grado');// PREGUNTAR NOMBRE
            $table->string('bio_oi_cri', 25)->comment('Biomicroscopia ojo izquierdo cristalino');
            $table->string('bio_oi_con', 25)->comment('Biomicroscopia ojo izquierdo conjuntiva');
            $table->string('bio_oi_iris', 25)->comment('Biomicroscopia ojo izquierdo iris');
            $table->string('bio_oi_pre', 25)->comment('Biomicroscopia ojo izquierdo presion');
            $table->string('bio_oi_cor', 25)->comment('Biomicroscopia ojo izquierdo cornea');
            $table->string('bio_oi_ref', 25)->comment('Biomicroscopia ojo izquierdo reflejo');
            $table->string('bio_oi_ocu', 25)->comment('Biomicroscopia ojo izquierdo ocular');
            $table->string('bio_oi_pup', 25)->comment('Biomicroscopia ojo izquierdo pupilar');

            // Campos Fondo de Ojo ojo derecho
            $table->string('fon_od_pap', 25)->comment('Fondo de ojo derecho papila');
            $table->string('fon_od_vit', 25)->comment('Fondo de ojo derecho vitreo');
            $table->string('fon_od_mac', 25)->comment('Fondo de ojo derecho macula');
            $table->string('fon_od_per', 25)->comment('Fondo de ojo derecho periferia');
            $table->string('fon_od_vas', 25)->comment('Fondo de ojo derecho vasos');
            $table->string('fon_od_retina', 25)->comment('Fondo de ojo derecho retina');
            $table->string('fon_od_retinales', 25)->comment('Fondo de ojo derecho retinales');

            // Campos Fondo de Ojo ojo izquierdo
            $table->string('fon_oi_pap', 25)->comment('Fondo de ojo izquierdo papila');
            $table->string('fon_oi_vit', 25)->comment('Fondo de ojo izquierdo vitreo');
            $table->string('fon_oi_mac', 25)->comment('Fondo de ojo izquierdo macula');
            $table->string('fon_oi_per', 25)->comment('Fondo de ojo izquierdo periferia');
            $table->string('fon_oi_vas', 25)->comment('Fondo de ojo izquierdo vasos');
            $table->string('fon_oi_retina', 25)->comment('Fondo de ojo izquierdo retina');
            $table->string('fon_oi_retinales', 25)->comment('Fondo de ojo izquierdo retinales');

            // Diagnostico
            $table->string('diagnostico')->comment('Diagnostico');

            // Tratamiento
            $table->string('tratamiento')->comment('Tratamiento');

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
