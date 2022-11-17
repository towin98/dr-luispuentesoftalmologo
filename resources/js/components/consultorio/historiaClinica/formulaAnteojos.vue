<template>
    <div>
        <loadingGeneral v-bind:overlayLoading="overlayLoading" />
        <!-- FormulaAnteojosController.php -->
        <v-card elevation="2" class="negativovMarginTopImprimir">
            <h3 class="text-center">HISTORIA CLINICA - {{ numero_formula_anteojos }}</h3><!-- FORMULA ANTEOJOS -->

            <!-- Datos del paciente -->
            <h4 class="ml-5">Datos del Paciente</h4>

            <v-row class="ml-2 mr-2 pt-5">
                <v-col cols="6" sm="3">
                    <v-text-field
                        type="date"
                        v-model="form.fecha_formula"
                        :error-messages="erroresFormulaAnteojos.fecha_formula"
                        title="Fecha Formula"
                        dense
                        label="Fecha Formula"
                    ></v-text-field>
                </v-col>
                <v-col cols="6" sm="3">
                    <v-text-field
                        v-model="numero_documento"
                        label="Número de Documento"
                        dense
                        disabled
                    ></v-text-field>
                </v-col>
                <v-col cols="6" sm="3">
                    <v-text-field
                        v-model="nombre"
                        label="Nombre"
                        dense
                        disabled
                    ></v-text-field>
                </v-col>
                <v-col cols="6" sm="3">
                    <v-text-field
                        v-model="apellido"
                        label="Apellido"
                        dense
                        disabled
                    ></v-text-field>
                </v-col>

                <!-- siguiente linea -->
                <v-col cols="6" sm="3">
                    <v-text-field
                        type="date"
                        v-model="fecha_nacimiento"
                        dense
                        label="Fecha nacimiento"
                        disabled
                    ></v-text-field>
                </v-col>
                <v-col cols="6" sm="3">
                    <v-text-field
                        v-model="edad"
                        label="Edad"
                        dense
                        disabled
                    ></v-text-field>
                </v-col>
            </v-row>

            <!-- Linea para separar -->
            <div style="height: 30px; margin-left: 40px; margin-right: 40px;">
                <hr style="height: 6px; border: none; background: #bdbdbd; border-radius: 3px;">
            </div>

            <!-- Antecedentes start -->
            <h4 class="ml-5">Antecedentes</h4>
            <v-row class="ml-2 mr-2">
                <v-col cols="6" sm="4" class="pb-0">
                    <v-checkbox
                        v-model="form.antecedentes"
                        label="Diabético"
                        value="DIABETICO"
                        dense
                    ></v-checkbox>
                </v-col>
                <v-col cols="6" sm="4" class="pb-0">
                    <v-checkbox
                        v-model="form.antecedentes"
                        label="CardioPulmonar"
                        value="CARDIOPULMONAR"
                        dense
                    ></v-checkbox>
                </v-col>
                <v-col cols="6" sm="4" class="pb-0">
                    <v-checkbox
                        v-model="form.antecedentes"
                        label="Alérgico"
                        value="ALERGICO"
                        dense
                    ></v-checkbox>
                </v-col>
                <v-col cols="6" sm="4" class="pb-0 pt-0">
                    <v-checkbox
                        v-model="form.antecedentes"
                        label="Hipertenso"
                        value="HIPERTENSO"
                        dense
                    ></v-checkbox>
                </v-col>
                <v-col cols="6" sm="4" class="pb-0 pt-0">
                    <v-checkbox
                        v-model="form.antecedentes"
                        label="CX Oculares"
                        value="CXOCULARES"
                        dense
                    ></v-checkbox>
                </v-col>
                <v-col cols="6" sm="4" class="pb-0 pt-0">
                    <v-text-field
                        v-model="form.otro"
                        label="Otro"
                        placeholder="cuales"
                        dense
                    ></v-text-field>
                </v-col>
                <v-col cols="12">
                    <v-alert type="error" v-if="erroresAntecedentes != ''">
                        <div v-for="(item, index) in erroresAntecedentes" :key="item.id">
                            {{ item[0] }}
                        </div>
                    </v-alert>
                </v-col>
            </v-row>
            <!-- Antecedentes end -->

            <!-- Linea para separar -->
            <div style="height: 30px; margin-left: 40px; margin-right: 40px;">
                <hr style="height: 6px; border: none; background: #bdbdbd; border-radius: 3px;">
            </div>
            <!-- Examen Optométrico start -->
            <h4 class="ml-5">Examen Optométrico</h4>
            <v-row class="ml-2 mr-2 pt-5">
                <v-col sm="6" cols="12" class="pt-0">
                    <table style="width: 100%; border-collapse: collapse;">
                        <tr>
                            <td style="background-color: #f0f0f0; border-top-left-radius: 14px; border-bottom-left-radius: 14px;">
                                <v-subheader class="pr-1 pl-1">OD*</v-subheader>
                                <v-subheader class="pr-1 pl-1">OI*</v-subheader>
                            </td>
                            <td style="background-color: #f0f0f0; border-top-right-radius: 14px; border-bottom-right-radius: 14px;">
                                <h5 class="">AVS CC - RX USO</h5>
                                <v-text-field
                                    v-model="form.avs_cc_od"
                                    :error-messages="erroresFormulaAnteojos.avs_cc_od"
                                    title="Agudeza Visual con correccion ojo derecho"
                                    single-line
                                    dense
                                    solo
                                    class="pr-1"
                                ></v-text-field>
                                <v-text-field
                                    v-model="form.avs_cc_oi"
                                    :error-messages="erroresFormulaAnteojos.avs_cc_oi"
                                    title="Agudeza Visual con correccion ojo izquierdo"
                                    single-line
                                    dense
                                    solo
                                    class="pr-1"
                                ></v-text-field>
                            </td>
                            <td>
                                <v-subheader class="pr-1 pl-1">OD*</v-subheader>
                                <v-subheader class="pr-1 pl-1">OI*</v-subheader>
                            </td>
                            <td>
                                <h5 class="">AVS SC</h5>
                                <v-text-field
                                    v-model="form.avs_sc_od"
                                    :error-messages="erroresFormulaAnteojos.avs_sc_od"
                                    title="Agudeza Visual sin correccion ojo derecho"
                                    single-line
                                    dense
                                    solo
                                ></v-text-field>
                                <v-text-field
                                    v-model="form.avs_sc_oi"
                                    :error-messages="erroresFormulaAnteojos.avs_sc_oi"
                                    title="Agudeza Visual sin correccion ojo Izquierdo"
                                    single-line
                                    dense
                                    solo
                                ></v-text-field>
                            </td>
                        </tr>
                    </table>
                </v-col>

                <v-col sm="6" cols="12" class="pt-0">
                    <table style="width: 100%; border-collapse: collapse;">
                        <tr>
                            <td style="background-color: #f0f0f0; border-top-left-radius: 14px; border-bottom-left-radius: 14px;">
                                <v-subheader class="pr-1 pl-1">OD*</v-subheader>
                                <v-subheader class="pr-1 pl-1">OI*</v-subheader>
                            </td>
                            <td style="background-color: #f0f0f0; border-top-right-radius: 14px; border-bottom-right-radius: 14px;">
                                <h5 class="pb-2">Refracción Subjetiva</h5>
                                <v-text-field
                                    v-model="form.ref_sub_od"
                                    :error-messages="erroresFormulaAnteojos.ref_sub_od"
                                    title="Refracción Subjetiva Ojo Derecho"
                                    single-line
                                    dense
                                    solo
                                    class="pr-1"
                                ></v-text-field>
                                <v-text-field
                                    v-model="form.ref_sub_oi"
                                    :error-messages="erroresFormulaAnteojos.ref_sub_oi"
                                    title="Refracción Subjetiva Ojo izquierdo"
                                    single-line
                                    dense
                                    solo
                                    class="pr-1"
                                ></v-text-field>
                            </td>
                            <td>
                                <v-subheader class="pr-1 pl-1">OD*</v-subheader>
                                <v-subheader class="pr-1 pl-1">OI*</v-subheader>
                            </td>
                            <td>
                                <h5 class="pb-2">Queratrometria</h5>
                                <v-text-field
                                    v-model="form.que_od"
                                    :error-messages="erroresFormulaAnteojos.que_od"
                                    title="Queratometría Ojo Derecho"
                                    single-line
                                    dense
                                    solo
                                    class="pr-1"
                                ></v-text-field>
                                <v-text-field
                                    v-model="form.que_oi"
                                    :error-messages="erroresFormulaAnteojos.que_oi"
                                    title="Queratometría Ojo Izquierdo"
                                    single-line
                                    dense
                                    solo
                                    class="pr-1"
                                ></v-text-field>
                            </td>
                        </tr>
                    </table>
                </v-col>
            </v-row>

            <v-row class="ml-2 mr-2 mb-4">
                <v-col sm="6" cols="12" class="pt-0">
                    <table style="width: 100%; border-collapse: collapse;">
                        <tr>
                            <td>
                                <v-subheader class="pr-1 pl-1">OD*</v-subheader>
                                <v-subheader class="pr-1 pl-1">OI*</v-subheader>
                            </td>
                            <td>
                                <h5 class="">RX</h5>
                                <v-text-field
                                    v-model="form.rx_od"
                                    :error-messages="erroresFormulaAnteojos.rx_od"
                                    title="RX ojo derecho"
                                    single-line
                                    dense
                                    solo
                                    class="pr-1"
                                ></v-text-field>
                                <v-text-field
                                    v-model="form.rx_oi"
                                    :error-messages="erroresFormulaAnteojos.rx_oi"
                                    title="RX ojo Izquierdo"
                                    single-line
                                    dense
                                    solo
                                    class="pr-1"
                                ></v-text-field>
                            </td>
                            <td>
                                <v-subheader class="pr-1 pl-1">Adicion</v-subheader>
                                <v-subheader class="pr-1 pl-1">DP</v-subheader>
                            </td>
                            <td>
                                <v-text-field
                                    v-model="form.adicion"
                                    :error-messages="erroresFormulaAnteojos.adicion"
                                    title="Adición"
                                    single-line
                                    dense
                                ></v-text-field>
                                <v-text-field
                                    v-model="form.dp"
                                    :error-messages="erroresFormulaAnteojos.dp"
                                    title="Distancia Pupilar"
                                    single-line
                                    dense
                                ></v-text-field>
                            </td>
                        </tr>
                    </table>
                </v-col>
                <v-col sm="6" cols="12">
                    <v-textarea
                        v-model="form.observacion"
                        :error-messages="erroresFormulaAnteojos.observacion"
                        rows="2"
                        outlined
                        label="Observación">
                    </v-textarea>
                </v-col>
            </v-row>

            <!-- Examen Optométrico end -->

            <!-- Linea para separar -->
            <div style="height: 30px; margin-left: 40px; margin-right: 40px;">
                <hr style="height: 6px; border: none; background: #bdbdbd; border-radius: 3px;">
            </div>

            <!-- Motivo consulta start -->
            <h4 class="ml-5">Motivo de Consulta</h4>

            <v-row class="ml-2 mr-2">
                <v-col cols="12" sm="12">
                    <div v-if="url_refraccion == '' || url_refraccion == null">
                        <label for="id_refracciones">Subir Refracciones:</label>
                        <input type="file" id="inputArchivos" accept="image/*" multiple style="width:50%;" title="Subir Refracciones, solo imagenes">
                        <div style="color:#b71c1c;" v-if="erroresMotivoConsulta.url_refraccion != undefined ">{{ erroresMotivoConsulta.url_refraccion[0] }}</div>
                    </div>
                    <div v-else>
                        Refracción:
                        <v-btn
                            type="click"
                            small
                            color="primary"
                            class="white--text text-none mr-3"
                            tile
                            v-on:click="url_refraccion = ''">
                            Remover
                        </v-btn>
                    </div>
                </v-col>
                <v-col cols="12" sm="12">
                    <v-textarea
                        v-model="form.descripcion_motivo_consulta"
                        ref="descripcion_motivo_consulta"
                        label="Descripción Motivo Consulta"
                        outlined
                        dense
                        :error-messages="erroresMotivoConsulta.descripcion_motivo_consulta"
                        rows="2"
                        >
                    </v-textarea>
                </v-col>
            </v-row>
            <!-- Motivo consulta end -->

            <!-- Linea para separar -->
            <div style="height: 30px; margin-left: 40px; margin-right: 40px;">
                <hr style="height: 6px; border: none; background: #bdbdbd; border-radius: 3px;"/>
            </div>
            <!-- Examen Oftalmológico start -->
            <h4 class="ml-5">Examen Oftalmológico</h4>

            <v-row class="ml-2 mr-2 mt-5">
                <v-col sm="1" cols="6">
                    <v-subheader>PPC:</v-subheader>
                </v-col>
                <!-- Segunda columna -->
                <v-col sm="2" cols="6">
                    <v-textarea
                        v-model="form.ppc"
                        :error-messages="erroresFormulaAnteojos.ppc"
                        hint="Punto Próximo de Convergencia"
                        rows="1"
                        auto-grow
                        dense
                    ></v-textarea>
                </v-col>
                <!-- Tercera columna -->
                <v-col sm="1" cols="6">
                    <v-subheader>Motilidad ocular</v-subheader>
                </v-col>
                <!-- Cuarta columna -->
                <v-col sm="2" cols="6">
                    <v-textarea
                        v-model="form.motilidad_ocular"
                        :error-messages="erroresFormulaAnteojos.motilidad_ocular"
                        hint="Motilidad ocular"
                        rows="1"
                        auto-grow
                        dense
                    ></v-textarea>
                </v-col>
                <v-col sm="1" cols="6">
                    <v-subheader>Hirschberg</v-subheader>
                </v-col>
                <v-col sm="2" cols="6">
                    <v-textarea
                        v-model="form.hirschberg"
                        :error-messages="erroresFormulaAnteojos.hirschberg"
                        hint="Hirschberg"
                        rows="1"
                        auto-grow
                        dense
                    ></v-textarea>
                </v-col>
                <v-col sm="1" cols="6">
                    <v-subheader>Cover Test</v-subheader>
                </v-col>
                <v-col sm="2" cols="6">
                    <v-textarea
                        v-model="form.cover_test"
                        :error-messages="erroresFormulaAnteojos.cover_test"
                        hint="Cover Test"
                        rows="1"
                        auto-grow
                        dense
                    ></v-textarea>
                </v-col>
            </v-row>

            <!-- BIOMICROSCOPIA -->
            <v-row class="ml-2 mr-2 pt-5">
                <v-col sm="6" cols="12" style="border: solid 1px #000; border-radius:22px;">
                    <h5>BIOMICROSCOPIA OD:*</h5>
                    <v-row class="pt-4">
                        <v-col sm="6" cols="12" class="pt-0 pb-0 pl-1 pr-1">
                            <v-textarea
                                v-model="form.bio_od_par"
                                :error-messages="erroresFormulaAnteojos.bio_od_par"
                                label="Parpados"
                                title="Parpados ojo derecho"
                                rows="1"
                                auto-grow
                                outlined
                                dense
                            ></v-textarea>
                            <v-textarea
                                v-model="form.bio_od_con"
                                :error-messages="erroresFormulaAnteojos.bio_od_con"
                                label="Conjuntiva"
                                title="Conjuntiva ojo derecho"
                                rows="1"
                                auto-grow
                                outlined
                                dense
                            ></v-textarea>
                        </v-col>
                        <v-col sm="6" cols="12" class="pt-0 pb-0 pl-1 pr-1">
                            <v-textarea
                                v-model="form.bio_od_cor"
                                :error-messages="erroresFormulaAnteojos.bio_od_cor"
                                label="Cornea"
                                title="Cornea ojo derecho"
                                rows="1"
                                auto-grow
                                outlined
                                dense
                            ></v-textarea>
                            <v-textarea
                                v-model="form.bio_od_ang"
                                :error-messages="erroresFormulaAnteojos.bio_od_ang"
                                label="Angulo"
                                title="Angulo ojo derecho"
                                rows="1"
                                auto-grow
                                outlined
                                dense
                            ></v-textarea>
                        </v-col>
                        <v-col sm="6" cols="12" class="pt-0 pb-0 pl-1 pr-1">
                            <v-textarea
                                v-model="form.bio_od_iris"
                                :error-messages="erroresFormulaAnteojos.bio_od_iris"
                                label="Iris"
                                title="Iris ojo derecho"
                                rows="1"
                                auto-grow
                                outlined
                                dense
                            ></v-textarea>
                            <v-textarea
                                v-model="form.bio_od_rpu"
                                :error-messages="erroresFormulaAnteojos.bio_od_rpu"
                                label="Reflejo Pupilar"
                                title="Reflejo Pupilar ojo derecho"
                                rows="1"
                                auto-grow
                                outlined
                                dense
                            ></v-textarea>
                        </v-col>
                        <v-col sm="6" cols="12" class="pt-0 pb-0 pl-1 pr-1">
                            <v-textarea
                                v-model="form.bio_od_cri"
                                :error-messages="erroresFormulaAnteojos.bio_od_cri"
                                label="Cristalino"
                                title="Cristalino ojo derecho"
                                rows="1"
                                auto-grow
                                outlined
                                dense
                            ></v-textarea>
                            <v-textarea
                                v-model="form.bio_od_pro"
                                :error-messages="erroresFormulaAnteojos.bio_od_pro"
                                label="Presión Ocular"
                                title="Presión Ocular ojo derecho"
                                rows="1"
                                auto-grow
                                outlined
                                dense
                            ></v-textarea>
                        </v-col>
                        <v-col sm="6" cols="12" class="pt-0 pb-0 pl-1 pr-1">
                            <v-textarea
                                v-model="form.bio_od_dil"
                                :error-messages="erroresFormulaAnteojos.bio_od_dil"
                                label="Dilatación"
                                title="Dilatación ojo derecho"
                                rows="1"
                                auto-grow
                                outlined
                                dense
                            ></v-textarea>
                        </v-col>
                    </v-row>
                </v-col>

                <v-col sm="6" cols="12" style="border: solid 1px #000; border-radius:22px;">
                    <h5>BIOMICROSCOPIA OI:*</h5>
                    <v-row class="pt-4">
                        <v-col sm="6" cols="12" class="pt-0 pb-0 pl-1 pr-1">
                            <v-textarea
                                v-model="form.bio_oi_par"
                                :error-messages="erroresFormulaAnteojos.bio_oi_par"
                                title="Parpados ojo izquierdo"
                                label="Parpados"
                                rows="1"
                                auto-grow
                                outlined
                                dense
                            ></v-textarea>
                            <v-textarea
                                v-model="form.bio_oi_con"
                                :error-messages="erroresFormulaAnteojos.bio_oi_con"
                                title="Conjuntiva ojo izquierdo"
                                label="Conjuntiva"
                                rows="1"
                                auto-grow
                                outlined
                                dense
                            ></v-textarea>
                        </v-col>
                        <v-col sm="6" cols="12" class="pt-0 pb-0 pl-1 pr-1">
                            <v-textarea
                                v-model="form.bio_oi_cor"
                                :error-messages="erroresFormulaAnteojos.bio_oi_cor"
                                title="Cornea ojo izquierdo"
                                label="Cornea"
                                rows="1"
                                auto-grow
                                outlined
                                dense
                            ></v-textarea>
                            <v-textarea
                                v-model="form.bio_oi_ang"
                                :error-messages="erroresFormulaAnteojos.bio_oi_ang"
                                title="Angulo ojo izquierdo"
                                label="Angulo"
                                rows="1"
                                auto-grow
                                outlined
                                dense
                            ></v-textarea>
                        </v-col>
                        <v-col sm="6" cols="12" class="pt-0 pb-0 pl-1 pr-1">
                            <v-textarea
                                v-model="form.bio_oi_iris"
                                :error-messages="erroresFormulaAnteojos.bio_oi_iris"
                                title="Iris ojo izquierdo"
                                label="Iris"
                                rows="1"
                                auto-grow
                                outlined
                                dense
                            ></v-textarea>
                            <v-textarea
                                v-model="form.bio_oi_rpu"
                                :error-messages="erroresFormulaAnteojos.bio_oi_rpu"
                                title="Reflejo Pupilar ojo izquierdo"
                                label="Reflejo Pupilar"
                                rows="1"
                                auto-grow
                                outlined
                                dense
                            ></v-textarea>
                        </v-col>
                        <v-col sm="6" cols="12" class="pt-0 pb-0 pl-1 pr-1">
                            <v-textarea
                                v-model="form.bio_oi_cri"
                                :error-messages="erroresFormulaAnteojos.bio_oi_cri"
                                title="Cristalino ojo izquierdo"
                                label="Cristalino"
                                rows="1"
                                auto-grow
                                outlined
                                dense
                            ></v-textarea>
                            <v-textarea
                                v-model="form.bio_oi_pro"
                                :error-messages="erroresFormulaAnteojos.bio_oi_pro"
                                title="Presión Ocular ojo izquierdo"
                                label="Presión Ocular"
                                rows="1"
                                auto-grow
                                outlined
                                dense
                            ></v-textarea>
                        </v-col>
                        <v-col sm="6" cols="12" class="pt-0 pb-0 pl-1 pr-1">
                            <v-textarea
                                v-model="form.bio_oi_dil"
                                :error-messages="erroresFormulaAnteojos.bio_oi_dil"
                                label="Dilatación"
                                title="Dilatación ojo izquierdo"
                                rows="1"
                                auto-grow
                                outlined
                                dense
                            ></v-textarea>
                        </v-col>
                    </v-row>
                </v-col>
            </v-row>

            <!-- FONDO DE OJO -->
            <h5 class="text-center pt-4">FONDO DE OJO</h5>
            <v-row class="ml-2 mr-2 pt-4">
                <v-col sm="6" cols="12" style="border: solid 1px #000; border-radius:22px;">
                    <h5>OD*</h5>
                    <v-row>
                        <v-col sm="6" cols="6" class="pt-3">
                            <v-textarea
                                v-model="form.fon_od_pap"
                                :error-messages="erroresFormulaAnteojos.fon_od_pap"
                                title="Papila ojo derecho"
                                label="Papila"
                                rows="1"
                                auto-grow
                                outlined
                                dense
                            ></v-textarea>
                            <v-textarea
                                v-model="form.fon_od_mac"
                                :error-messages="erroresFormulaAnteojos.fon_od_mac"
                                title="Macula ojo derecho"
                                label="Macula"
                                rows="1"
                                auto-grow
                                outlined
                                dense
                            ></v-textarea>
                            <v-textarea
                                v-model="form.fon_od_vre"
                                :error-messages="erroresFormulaAnteojos.fon_od_vre"
                                title="Vasos Retinales ojo derecho"
                                label="Vasos Retinales"
                                rows="1"
                                auto-grow
                                outlined
                                dense
                            ></v-textarea>
                        </v-col>

                        <v-col sm="6" cols="6" class="pt-3">
                            <v-textarea
                                v-model="form.fon_od_vit"
                                :error-messages="erroresFormulaAnteojos.fon_od_vit"
                                title="Vitreo ojo derecho"
                                label="Vitreo"
                                rows="1"
                                auto-grow
                                outlined
                                dense
                            ></v-textarea>
                            <v-textarea
                                v-model="form.fon_od_per"
                                :error-messages="erroresFormulaAnteojos.fon_od_per"
                                title="Periferia ojo derecho"
                                label="Periferia"
                                rows="1"
                                auto-grow
                                outlined
                                dense
                            ></v-textarea>
                            <v-textarea
                                v-model="form.fon_od_retina"
                                :error-messages="erroresFormulaAnteojos.fon_od_retina"
                                title="Retina ojo derecho"
                                label="Retina"
                                rows="1"
                                auto-grow
                                outlined
                                dense
                            ></v-textarea>
                        </v-col>
                    </v-row>
                </v-col>
                <v-col sm="6" cols="12" style="border: solid 1px #000; border-radius:22px;">
                    <h5>OI:*</h5>
                    <v-row>
                        <v-col sm="6" cols="6" class="pt-3">
                            <v-textarea
                                v-model="form.fon_oi_pap"
                                :error-messages="erroresFormulaAnteojos.fon_oi_pap"
                                title="Papila ojo izquierdo"
                                label="Papila"
                                rows="1"
                                auto-grow
                                outlined
                                dense
                            ></v-textarea>
                            <v-textarea
                                v-model="form.fon_oi_mac"
                                :error-messages="erroresFormulaAnteojos.fon_oi_mac"
                                title="Macula ojo izquierdo"
                                label="Macula"
                                rows="1"
                                auto-grow
                                outlined
                                dense
                            ></v-textarea>
                            <v-textarea
                                v-model="form.fon_oi_vre"
                                :error-messages="erroresFormulaAnteojos.fon_oi_vre"
                                title="Vasos Retinales ojo izquierdo"
                                label="Vasos Retinales"
                                rows="1"
                                auto-grow
                                outlined
                                dense
                            ></v-textarea>
                        </v-col>

                        <v-col sm="6" cols="6" class="pt-3">
                            <v-textarea
                                v-model="form.fon_oi_vit"
                                :error-messages="erroresFormulaAnteojos.fon_oi_vit"
                                title="Vitreo ojo izquierdo"
                                label="Vitreo"
                                rows="1"
                                auto-grow
                                outlined
                                dense
                            ></v-textarea>
                            <v-textarea
                                v-model="form.fon_oi_per"
                                :error-messages="erroresFormulaAnteojos.fon_oi_per"
                                title="Periferia ojo izquierdo"
                                label="Periferia"
                                rows="1"
                                auto-grow
                                outlined
                                dense
                            ></v-textarea>
                            <v-textarea
                                v-model="form.fon_oi_retina"
                                :error-messages="erroresFormulaAnteojos.fon_oi_retina"
                                title="Retina ojo izquierdo"
                                label="Retina"
                                rows="1"
                                auto-grow
                                outlined
                                dense
                            ></v-textarea>
                        </v-col>
                    </v-row>
                </v-col>
            </v-row>
            <v-row class="ml-1 mr-1 pt-4">
                <v-col cols="12" sm="6" class="pb-0">
                    <v-textarea
                        v-model="form.diagnostico"
                        :error-messages="erroresFormulaAnteojos.diagnostico"
                        rows="2"
                        outlined
                        label="Diagnostico"
                        ></v-textarea>
                </v-col>

                <v-col cols="12" sm="6"  class="pb-0">
                    <v-textarea
                        v-model="form.tratamiento"
                        :error-messages="erroresFormulaAnteojos.tratamiento"
                        rows="2"
                        outlined
                        label="Tratamiento"
                    ></v-textarea>
                </v-col>

                <v-col cols="12" sm="6" class="pb-0 pt-0">
                    <v-textarea
                        v-model="form.orden_medica"
                        :error-messages="erroresFormulaAnteojos.orden_medica"
                        rows="2"
                        outlined
                        label="Orden Medica"
                    >
                    </v-textarea>
                </v-col>

                <v-col cols="12" sm="6" class="pb-0 pt-0">
                    <v-textarea
                        v-model="form.observaciones2"
                        :error-messages="erroresFormulaAnteojos.observaciones2"
                        rows="2"
                        outlined
                        label="Observaciones"
                    >
                    </v-textarea>
                </v-col>
            </v-row>
            <!-- Examen Oftalmológico end -->

            <firmaFormulario/>

            <v-row class="pl-4 pr-4 parte1">
                <!-- BOTONES ACCIONES  -->
                <v-col cols="12" sm="6">
                    <!-- Evolucioón  -->
                    <v-btn
                        type="button"
                        small
                        color="success"
                        class="white--text text-none mb-2"
                        tile
                        v-on:click="fnAbrirEvolucion()"
                        v-if="cAccion == 'Actualizar'"
                    >
                        Ir a Evolución
                        <v-icon right> arrow_forward_ios </v-icon>
                    </v-btn>
                    <br>
                    <v-btn
                        type="submit"
                        small
                        color="red darken-4"
                        class="white--text text-none"
                        tile
                        v-on:click="fnDescargarPdfHistoriaClinica('formula')"
                        v-if="cAccion == 'Actualizar'"
                        :disabled="!$can(['EDITAR'])"
                    >
                        Imprimir formula
                        <v-icon right> picture_as_pdf </v-icon>
                    </v-btn>
                    <v-btn
                        type="submit"
                        small
                        color="red darken-4"
                        class="white--text text-none"
                        tile
                        v-on:click="fnAbrirModalImprimirOrdenMedica(true)"
                        v-if="cAccion == 'Actualizar'"
                        :disabled="!$can(['EDITAR'])"
                    >
                        Imprimir Orden Medica
                        <v-icon right> picture_as_pdf </v-icon>
                    </v-btn>
                    <v-btn
                        type="submit"
                        small
                        color="red darken-4"
                        class="white--text text-none"
                        tile
                        v-on:click="fnDescargarPdfHistoriaClinica('rx')"
                        v-if="cAccion == 'Actualizar'"
                        :disabled="!$can(['EDITAR'])"
                    >
                        Imprimir RX
                        <v-icon right> picture_as_pdf </v-icon>
                    </v-btn>

                    <br>

                    <!-- Descargar Refracción  -->
                    <v-btn
                        type="button"
                        small
                        color="red darken-4"
                        class="white--text text-none mt-1"
                        tile
                        v-on:click="fnDescargarRefraccion"
                        v-if="url_refraccion != '' && url_refraccion != null"
                    >
                        Descargar Refracción
                        <v-icon right> picture_as_pdf </v-icon>
                    </v-btn>
                </v-col>
                <v-col cols="12" sm="6" class="d-flex justify-end">
                    <v-btn
                        type="button"
                        small
                        color="grey"
                        class="white--text mr-3"
                        tile
                        v-on:click="fnImprimirFormulario()"
                        v-if="cAccion == 'Actualizar'"
                        :disabled="!$can(['EDITAR'])"
                    >
                        Imprimir formulario
                        <v-icon right> print </v-icon>
                    </v-btn>
                    <v-btn
                        type="submit"
                        small
                        color="yellow"
                        class="text-none mr-3"
                        title="Vacía campos del formulario para crear nueva formula anteojos."
                        tile
                        @click="limpiarCampos"
                    >
                        <v-icon left> format_clear </v-icon>Limpiar
                    </v-btn>
                    <v-btn
                        type="submit"
                        small
                        color="success"
                        class="white--text text-none"
                        tile
                        v-on:click="fnAccion"
                        :disabled="!$can(['CREAR', 'EDITAR'])"
                    >
                        {{ cAccion }}
                        <v-icon right> save </v-icon>
                    </v-btn>
                </v-col>
            </v-row>
        </v-card>
        <!-- FIN FORMULARIO -->

        <!-- start Data table -->
        <v-row class="parte1">
            <v-col cols="12">
                <v-card-title>
                    <v-text-field
                        type="text"
                        append-icon="mdi-magnify"
                        label="Buscar"
                        single-line
                        hide-details
                        v-model="buscar"
                        @input="filterSearch"
                        :disabled="!$can(['LISTAR']) || loading"
                    ></v-text-field>
                </v-card-title>
                <v-data-table
                    :page="page"
                    :headers="headers"
                    :items="dataSet"
                    :options.sync="options"
                    :server-items-length="totalRegistros"
                    :loading="loading"
                    class="elevation-1"
                    :items-per-page="5"
                    :footer-props="{
                        'items-per-page-options': [5, 10, 15, 50],
                    }"
                    sort-by="updated_at"
                    :sort-desc="true"
                    no-data-text="Sin registros"
                    :disable-sort="!$can(['LISTAR'])"
                >
                    <template v-slot:item.acciones="{ item }">
                        <v-icon
                            color="primary"
                            class="mr-2"
                            @click="fnShow(item.id)"
                            title="Editar Formula Anteojos"
                            v-if="$can(['VER', 'EDITAR'])"
                        >
                            mdi-pencil
                        </v-icon>
                        <v-icon
                            color="red"
                            title="Eliminar Formula Anteojos."
                            @click="fnDelete(item)"
                            v-if="$can(['ELIMINAR'])"
                        >
                            mdi-delete
                        </v-icon>
                    </template>
                </v-data-table>
            </v-col>
        </v-row>
        <!-- end Data table -->

        <modalOrdenMedicaPdf ref="modalOrdenMedicaPdfEtiqueta" @fnDescargarPdf="fnDescargarPdfHistoriaClinica"></modalOrdenMedicaPdf>

    </div>
</template>
<script>
import loadingGeneral from "../../loadingGeneral/loadingGeneral.vue";
import firmaFormulario from "../../commons/firma-formulario.vue";
import modalOrdenMedicaPdf from "../../commons/modalOrdenMedicaPdf.vue";
export default {
    props: {
        idHistoriaClinica: {
            type: Number,
            default: 0
        },
    },
    components: {
        loadingGeneral,
        firmaFormulario,
        modalOrdenMedicaPdf
    },
    data() {
        return {
            /* Variables Table. */
            debounce: null,
            buscar: "",
            page: 1,
            totalRegistros: 0,
            loading: false,
            overlayLoading : false,
            options: {},
            headers: [
                { text: "Número Formula Anteojos", value: "numero_formula_anteojos" },
                { text: "Fecha Formula", value: "fecha_formula" },
                { text: "Nombre del Paciente", value: "nombre", sortable: false },
                { text: "Apellidos del Paciente", value: "apellido", sortable: false },
                { text: "Identificacion", value: "numero_documento", sortable: false },
                { text: "Fecha Modificado", value: "updated_at" },
                { text: "Acciones", value: "acciones", sortable: false },
            ],
            dataSet: [],
            contador : 0,

            // Variables de formulario.
            numero_formula_anteojos : '0000',
            cAccion                 : 'Guardar',

            // Variables de error formulario, validación.
            erroresAntecedentes : '',
            erroresFormulaAnteojos : '',
            erroresMotivoConsulta : '',

            // Variables para motivo de consulta
            url_refraccion   : '',

            form: {
                /* motivo consulta */
                id_motivo_consulta          : "",
                descripcion_motivo_consulta : '',

                /* antecedentes */
                id_antecedentes : "",
                antecedentes    : [],
                otro            : '',

                /* historia clinica */
                id                  : '',
                avs_cc_od           : '',
                avs_cc_oi           : '',
                avs_sc_od           : '',
                avs_sc_oi           : '',
                rx_od               : '',
                rx_oi               : '',
                adicion             : '',
                dp                  : '',
                observacion         : '',
                ref_obj_od          : '',
                ref_obj_oi          : '',
                ref_sub_od          : '',
                ref_sub_oi          : '',
                que_od              : '',
                que_oi              : '',
                hirschberg          : '',
                cover_test          : '',
                ppc                 : '',
                motilidad_ocular    : '',
                dilatacion_pupilar  : '',
                bio_od_par          : '',
                bio_od_ang          : '',
                bio_od_cri          : '',
                bio_od_con          : '',
                bio_od_iris         : '',
                bio_od_pro          : '',
                bio_od_cor          : '',
                bio_od_rpu          : '',
                bio_od_dil          : '',
                bio_oi_par          : '',
                bio_oi_ang          : '',
                bio_oi_cri          : '',
                bio_oi_con          : '',
                bio_oi_iris         : '',
                bio_oi_pro          : '',
                bio_oi_cor          : '',
                bio_oi_rpu          : '',
                bio_oi_dil          : '',
                fon_od_pap          : '',
                fon_od_vit          : '',
                fon_od_mac          : '',
                fon_od_per          : '',
                fon_od_vre          : '',
                fon_od_retina       : '',
                fon_oi_pap          : '',
                fon_oi_vit          : '',
                fon_oi_mac          : '',
                fon_oi_per          : '',
                fon_oi_vre          : '',
                fon_oi_retina       : '',
                diagnostico         : '',
                tratamiento         : '',
                orden_medica        : '',
                observaciones2      : ''
            },

            // Variables para mostrar solo información del paciente.
            numero_documento : '',
            nombre           : '',
            apellido         : '',
            fecha_nacimiento : '',
            edad             : '',

            // modalImprimirOrdenMedica : false
        }
    },
    watch: {
        options: {
            handler() {
                this.fnBuscar();
            },
        },
        deep: true,
    },
    methods:{
        filterSearch() {
            clearTimeout(this.debounce);
            this.debounce = setTimeout(() => {
                this.fnBuscar();
            }, 600);
        },
        fnBuscar() {

            this.overlayLoading = true;
            this.loading = true;

            let { page, itemsPerPage, sortBy, sortDesc } = this.options;

            // Obteniendo rangos de consultado paginación.
            let start  = itemsPerPage * (page - 1);
            let length = itemsPerPage;

            if (sortDesc[0] == true) {
                sortBy = sortBy[0];
                sortDesc = "DESC";
            } else if (sortDesc[0] == false) {
                sortBy = sortBy[0];
                sortDesc = "ASC";
            } else {
                sortBy   = "";
                sortDesc = "";
            }

            axios
                .get(
                    `/consultorio-oftamologico/historia-clinica/listar/formula-anteojos/${this.$route.params.numero_documento}?length=${length}&start=${start}&orderColumn=${sortBy}&order=${sortDesc}&buscar=${this.buscar}`
                )
                .then((response) => {
                    this.totalRegistros = response.data.total;
                    let data = response.data.data;

                    // Obteniendo información del paciente.
                    this.numero_documento = data[0].numero_documento;
                    this.nombre           = data[0].nombre;
                    this.apellido         = data[0].apellido;
                    this.fecha_nacimiento = data[0].fecha_nacimiento;
                    this.edad             = data[0].edad;

                    this.dataSet = data;

                    this.loading = false;
                    if (this.contador == 0 && this.idHistoriaClinica == 0) {
                        this.contador++;
                        this.fnObtenerNumeroFormulaAnteojos();
                    }
                    this.overlayLoading = false;

                })
                .catch((errors) => {
                    this.overlayLoading = false;
                    this.loading = false;
                    this.dataSet = [];
                });
        },
        fnObtenerNumeroFormulaAnteojos(){
            this.form.numero_documento = this.$route.params.numero_documento;
            // this.overlayLoading = true;
            axios
                .get(`/consultorio-oftamologico/historia-clinica/cosecutivo-formula-anteojos/${this.form.numero_documento}`)
                .then((response) => {
                    this.numero_formula_anteojos = response.data;
                    // this.overlayLoading = false;
                })
                .catch((errores) => {
                    this.fnResponseError(errores);
                    // this.overlayLoading = false;
                });
        },
        fnAccion(){
            if (this.cAccion === "Guardar") {
                this.fnStore();
            }else{
                this.fnUpdate();
            }
        },
        fnStore(){
            // this.form.numero_documento = this.$route.params.numero_documento;
            this.overlayLoading = true;

            const $inputArchivos = document.querySelector("#inputArchivos");
            const archivosParaSubir = $inputArchivos.files;

            let formData = new FormData();
            for (let key in this.form) {
                if (this.form[key] == null) {
                    this.form[key] = '';
                }

                switch (key) {
                    case 'antecedentes':
                        formData.append(key, this.form.antecedentes.toString());
                    break;
                    default:
                        formData.append(key, this.form[key]);
                    break;
                }
            }
            formData.append('numero_documento', this.numero_documento);

            if (archivosParaSubir.length <= 0) {
                formData.append("refracciones[]", "");
            }else{
                for (const archivo of archivosParaSubir) {
                    formData.append("refracciones[]", archivo);
                }
            }

            axios
                .post(`/consultorio-oftamologico/historia-clinica/guardar/formula-anteojos`, formData, {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    },
                })
                .then((response) => {
                    this.$swal(
                        response.data.message,
                        '',
                        'success'
                    );
                    this.fnBuscar();
                    this.limpiarCampos();
                    this.overlayLoading = false;
                })
                .catch((errores) => {
                    if (errores.response != undefined) {
                        if (errores.response.status == 401) {
                            return '';
                        }
                    }

                    let error = errores.response.data.errors;

                    this.erroresAntecedentes    = error.erroresAntecedentes    != undefined ? error.erroresAntecedentes    : "";
                    this.erroresFormulaAnteojos = error.erroresFormulaAnteojos != undefined ? error.erroresFormulaAnteojos : "";
                    this.erroresMotivoConsulta  = error.erroresMotivoConsulta  != undefined ? error.erroresMotivoConsulta  : "";

                    this.$swal({
                        icon: 'info',
                        title: `Existen validaciones en el formulario, por favor revise.`,
                        text: ``,
                    })

                    this.overlayLoading = false;
                });
        },
        fnUpdate(){
            this.overlayLoading = true;
            // this.form.numero_documento = this.$route.params.numero_documento;

            let formData = new FormData();
            for (let key in this.form) {
                if (this.form[key] == null) {
                    this.form[key] = '';
                }
                switch (key) {
                    case 'antecedentes':
                        formData.append(key, this.form.antecedentes.toString());
                    break;
                    default:
                        formData.append(key, this.form[key]);
                    break;
                }
            }
            formData.append('numero_documento', this.numero_documento);

            // Si url_refraccion es vacio es porque se esta mostrando el input para subir archivos
            // Entonces se examina si se subieron archivos para pasarlos por parametro.
            if (this.url_refraccion == "" || this.url_refraccion == null) {
                const $inputArchivos = document.querySelector("#inputArchivos");
                const archivosParaSubir = $inputArchivos.files;

                if (archivosParaSubir.length <= 0) {
                    formData.append("refracciones[]", "");
                }else{
                    for (const archivo of archivosParaSubir) {
                        formData.append("refracciones[]", archivo);
                    }
                }
            }

            axios
                .post(`/consultorio-oftamologico/historia-clinica/actualizar/formula-anteojos/${this.form.id}`, formData, {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    },
                })
                .then((response) => {
                    this.$swal(
                        response.data.message,
                        '',
                        'success'
                    );
                    this.fnBuscar();
                    this.limpiarCampos();
                    this.overlayLoading = false;
                })
                .catch((errores) => {
                    if (errores.response != undefined) {
                        if (errores.response.status == 401) {
                            return '';
                        }
                    }

                    let error = errores.response.data.errors;

                    if (errores.response.status == 422) {
                        this.erroresAntecedentes    = error.erroresAntecedentes != undefined ? error.erroresAntecedentes : "";
                        this.erroresFormulaAnteojos = error.erroresFormulaAnteojos != undefined ? error.erroresFormulaAnteojos : "";
                        this.erroresMotivoConsulta  = error.erroresMotivoConsulta != undefined ? error.erroresMotivoConsulta : "";
                        this.$swal({
                            icon: 'info',
                            title: `Existen validaciones en el formulario, por favor revise.`,
                            text: ``,
                        })
                    }else{
                        this.fnResponseError(errores);
                    }


                    this.overlayLoading = false;
                });
        },
        fnShow(id){
            this.overlayLoading = true;
            this.limpiarCampos();
            this.cAccion = "Actualizar";
            axios
                .get(`/consultorio-oftamologico/historia-clinica/mostrar/formula-anteojos/${id}`)
                .then((response) => {
                    let data = response.data.data;
                    this.numero_formula_anteojos = data.numero_formula_anteojos;

                    if (data.antecedentes == null || data.antecedentes == "") {
                        data.antecedentes = []
                    }else{
                        data.antecedentes = data.antecedentes.split(',');
                    }

                    this.url_refraccion   = data.url_refraccion;
                    this.form = data;

                    this.overlayLoading = false;
                })
                .catch((errores) => {
                    this.fnResponseError(errores);
                    this.overlayLoading = false;
                });
        },
        fnDelete(item){
            this.$swal({
            title: 'Quiere eliminar la Historia Clinica?',
            text: `Eliminar la Historia Clinica N°${item.numero_formula_anteojos}!`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si, Eliminar!'
            }).then((result) => {
                if (result.isConfirmed) {

                    this.overlayLoading = true;

                    axios.post(`/consultorio-oftamologico/historia-clinica/delete/formula-anteojos/${item.id}`)
                    .then((response) => {
                        this.errors = "";
                        this.$swal(
                            response.data.message,
                            '',
                            'success'
                        );
                        this.fnBuscar();
                        this.limpiarCampos();
                        this.overlayLoading = false;
                    })
                    .catch((errores) => {
                        this.fnResponseError(errores);
                        this.overlayLoading = false;
                    });

                }
            });
        },
        limpiarCampos(){
            this.fnLimpiarErrores();

            // Limpiando variables de Motivo Consulta.
            this.form.id_motivo_consulta = "";
            if (this.url_refraccion == "" || this.url_refraccion == null) {
                let $inputArchivos = document.querySelector("#inputArchivos");
                $inputArchivos.value    = "";
            }
            this.form.descripcion_motivo_consulta   = "";
            this.url_refraccion                     = "";

            // Limpiando variables antecedentes.
            this.form.id_antecedentes  = "";
            this.form.antecedentes     = [];
            this.form.otro             = '';

            // Limpiando Variables formula anteojos
            if (this.idHistoriaClinica == 0 || this.cAccion == "Actualizar") {
                this.fnObtenerNumeroFormulaAnteojos();
            }
            this.cAccion                  = "Guardar";
            this.form.id                  = '';
            this.form.fecha_formula       = '';
            this.form.avs_cc_od           = '';
            this.form.avs_cc_oi           = '';
            this.form.avs_sc_od           = '';
            this.form.avs_sc_oi           = '';
            this.form.rx_od               = '';
            this.form.rx_oi               = '';
            this.form.adicion             = '';
            this.form.dp                  = '';
            this.form.observacion         = '';
            this.form.ref_obj_oi          = '';
            this.form.ref_sub_od          = '';
            this.form.ref_sub_oi          = '';
            this.form.que_od              = '';
            this.form.que_oi              = '';
            this.form.hirschberg          = '';
            this.form.cover_test          = '';
            this.form.ppc                 = '';
            this.form.motilidad_ocular    = '';
            this.form.dilatacion_pupilar  = '';
            this.form.bio_od_par          = '';
            this.form.bio_od_ang          = '';
            this.form.bio_od_cri          = '';
            this.form.bio_od_con          = '';
            this.form.bio_od_iris         = '';
            this.form.bio_od_pro          = '';
            this.form.bio_od_cor          = '';
            this.form.bio_od_rpu          = '';
            this.form.bio_od_dil          = '';
            this.form.bio_oi_par          = '';
            this.form.bio_oi_ang          = '';
            this.form.bio_oi_cri          = '';
            this.form.bio_oi_con          = '';
            this.form.bio_oi_iris         = '';
            this.form.bio_oi_pro          = '';
            this.form.bio_oi_cor          = '';
            this.form.bio_oi_rpu          = '';
            this.form.bio_oi_dil          = '';
            this.form.fon_od_pap          = '';
            this.form.fon_od_vit          = '';
            this.form.fon_od_mac          = '';
            this.form.fon_od_per          = '';
            this.form.fon_od_vre          = '';
            this.form.fon_od_retina       = '';
            this.form.fon_oi_pap          = '';
            this.form.fon_oi_vit          = '';
            this.form.fon_oi_mac          = '';
            this.form.fon_oi_per          = '';
            this.form.fon_oi_vre          = '';
            this.form.fon_oi_retina       = '';
            this.form.diagnostico         = '';
            this.form.tratamiento         = '';
            this.form.orden_medica        = '';
            this.form.observaciones2      = '';
        },
        fnLimpiarErrores(){
            this.erroresAntecedentes    = "";
            this.erroresFormulaAnteojos = "";
            this.erroresMotivoConsulta  = "";
        },
        fnDescargarRefraccion(){
            this.overlayLoading = true;
            const data = {
                nombreArchivo : this.url_refraccion,
                path: 'storage/refracciones/'
            };
            axios
                .post(`/consultorio-oftamologico/historia-clinica/descargar/evolucion/refracciones`,data,  {responseType: 'blob',})
                .then((response) => {
                    const url = window.URL.createObjectURL(new Blob([response.data]))
                    const link = document.createElement('a')
                    link.href= url
                    link.setAttribute('download', this.url_refraccion)
                    document.body.appendChild(link)
                    link.click();

                    this.overlayLoading = false;
                })
                .catch((errores) => {
                    this.errors = this.fnResponseError(errores);
                    this.overlayLoading = false;
                });
        },
        fnImprimirFormulario(){
            window.print();
        },
        fnAbrirEvolucion(){
            // Navegando hacia el mdodulo de evolución.
            this.$router.push({name: "historia-clinica/evolucion", params: {idHistoriaClinica: this.form.id, consecutivo: this.form.numero_formula_anteojos, numero_documento: this.$route.params.numero_documento}});
        },
        fnDescargarPdfHistoriaClinica(reporte = '', info_centro = ''){
            let data = {};

            switch (reporte) {
                case 'orden_medica':
                    data.mostrar_info_centro = info_centro
                    this.fnAbrirModalImprimirOrdenMedica(false)
                break;
            }

            this.overlayLoading = true;

            data.tipo_reporte    = reporte;
            data.numero_documento= this.$route.params.numero_documento;
            data.id_formula      = this.form.id;

            axios
                .post(`/consultorio-oftamologico/historia-clinica/pdf/formula-anteojos`,data,  {responseType: 'blob',})
                .then((response) => {
                    let hoy = new Date();
                    let fecha = hoy.getDate() +""+ ( hoy.getMonth() + 1 ) +""+  hoy.getFullYear();
                    let hora = hoy.getHours() +""+  hoy.getMinutes() +""+  hoy.getSeconds();
                    const nombrePDF = reporte.toUpperCase()+"_"+fecha+""+hora+".pdf";

                    const url = window.URL.createObjectURL(new Blob([response.data]));
                    const link = document.createElement('a');
                    link.href= url;
                    link.setAttribute('download', nombrePDF);
                    document.body.appendChild(link);
                    link.click();

                    this.overlayLoading = false;
                })
                .catch((errores) => {
                    this.$swal({
                        icon: 'error',
                        title: ``,
                        text: `Error inesperado al generar PDF.`,
                    })
                    this.overlayLoading = false;
                });
        },
        fnAbrirModalImprimirOrdenMedica(val){
            this.$refs.modalOrdenMedicaPdfEtiqueta.fnAbrirModalImprimirOrdenMedicaLocal(val);
        }
    },
    mounted() {
        if (this.idHistoriaClinica != 0) {
            this.fnShow(this.idHistoriaClinica);
        }
    },
}
</script>
<style scoped>
.v-subheader{
    font-size: 13px !important;
}

.v-input  {
    font-size: 13px !important;
}

</style>
