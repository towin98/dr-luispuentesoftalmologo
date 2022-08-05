<template>
    <div>
        <loadingGeneral v-bind:overlayLoading="overlayLoading" />
        <!-- FORMULARIO -->
        <v-card elevation="2" class="mt-7">
            <h3 class="text-center">HISTORIA CLINICA - {{ numero_formula_anteojos }}</h3><!-- FORMULA ANTEOJOS -->

            <v-row class="ml-2 mr-2 pt-5">
                <v-col cols="12" sm="3">
                    <v-text-field
                        type="date"
                        v-model="form.fecha_formula"
                        :error-messages="errors.fecha_formula"
                        title="Fecha Formula"
                        dense
                        label="Fecha Formula"
                    ></v-text-field>
                </v-col>
            </v-row>

            <v-row class="ml-2 mr-2">
                <!-- Primera columna -->
                <v-col sm="1" cols="6" class="pt-3 pb-0" style="background-color: #f0f0f0; border-top-left-radius: 14px; border-bottom-left-radius: 14px;">
                    <v-subheader class="pl-0 mt-4">OD*</v-subheader>
                    <v-subheader class="pl-0 mt-4">OI*</v-subheader>
                </v-col>
                <!-- Segunda columna -->
                <v-col sm="2" cols="6" class="pt-3 pb-0" style="background-color: #f0f0f0; border-top-right-radius: 14px; border-bottom-right-radius: 14px;">
                    <h5 class="pb-2">AVS CC</h5>
                    <v-text-field
                        v-model="form.avs_cc_od"
                        :error-messages="errors.avs_cc_od"
                        title="Agudeza Visual con correccion ojo derecho"
                        single-line
                        dense
                        solo
                    ></v-text-field>
                    <v-text-field
                        v-model="form.avs_cc_oi"
                        :error-messages="errors.avs_cc_oi"
                        title="Agudeza Visual con correccion ojo izquierdo"
                        single-line
                        dense
                        solo
                    ></v-text-field>
                </v-col>
                <!-- Tercera columna -->
                <v-col sm="1" cols="6" class="pt-3 pb-0">
                    <v-subheader class="pl-0 mt-4">OD*</v-subheader>
                    <v-subheader class="pl-0 mt-4">OI*</v-subheader>
                </v-col>
                <!-- Cuarta columna -->
                <v-col sm="2" cols="6" class="pt-3 pb-0">
                    <h5 class="pb-2">AVS SC</h5>
                    <v-text-field
                        v-model="form.avs_sc_od"
                        :error-messages="errors.avs_sc_od"
                        title="Agudeza Visual sin correccion ojo derecho"
                        single-line
                        dense
                        solo
                    ></v-text-field>
                    <v-text-field
                        v-model="form.avs_sc_oi"
                        :error-messages="errors.avs_sc_oi"
                        title="Agudeza Visual sin correccion ojo Izquierdo"
                        single-line
                        dense
                        solo
                    ></v-text-field>
                </v-col>
                <!-- Quinta columna -->
                <v-col sm="1" cols="6" class="pt-3 pb-0" style="background-color: #f0f0f0; border-top-left-radius: 14px; border-bottom-left-radius: 14px;">
                    <v-subheader class="pl-0 mt-4">OD*</v-subheader>
                    <v-subheader class="pl-0 mt-4">OI*</v-subheader>
                </v-col>
                <!-- Sexta columna -->
                <v-col sm="2" cols="6" class="pt-3 pb-0" style="background-color: #f0f0f0; border-top-right-radius: 14px; border-bottom-right-radius: 14px;">
                    <h5 class="pb-2">RX</h5>
                    <v-text-field
                        v-model="form.rx_od"
                        :error-messages="errors.rx_od"
                        title="RX ojo derecho"
                        single-line
                        dense
                        solo
                    ></v-text-field>
                    <v-text-field
                        v-model="form.rx_oi"
                        :error-messages="errors.rx_oi"
                        title="RX ojo Izquierdo"
                        single-line
                        dense
                        solo
                    ></v-text-field>
                </v-col>
                <!-- Septima columna -->
                <v-col sm="1" cols="6" class="pt-1 pb-0">
                    <v-subheader class="pl-0">Adicion</v-subheader>
                    <v-subheader class="pl-0">DP</v-subheader>
                </v-col>
                <!-- Octava columna -->
                <v-col sm="2" cols="6" class="pt-1 pb-0">
                    <v-text-field
                        v-model="form.adicion"
                        :error-messages="errors.adicion"
                        title="Adición"
                        single-line
                        dense
                    ></v-text-field>
                    <v-text-field
                        v-model="form.dp"
                        :error-messages="errors.dp"
                        title="Distancia Pupilar"
                        single-line
                        dense
                    ></v-text-field>
                    <v-textarea
                        v-model="form.observacion"
                        :error-messages="errors.observacion"
                        rows="4"
                        outlined
                        label="Observación"
                    >
                    </v-textarea>
                </v-col>
            </v-row>

            <v-row class="ml-2 mr-2 pt-5">
                <v-col sm="1" cols="6" class="pt-3 pb-0" style="background-color: #f0f0f0; border-top-left-radius: 14px; border-bottom-left-radius: 14px;">
                    <v-subheader class="pl-0 mt-4">OD*</v-subheader>
                    <v-subheader class="pl-0 mt-4">OI*</v-subheader>
                </v-col>
                <!-- Segunda columna -->
                <v-col sm="2" cols="6" class="pt-3 pb-0" style="background-color: #f0f0f0; border-top-right-radius: 14px; border-bottom-right-radius: 14px;">
                    <h5 class="pb-2">Refracción Objetiva</h5>
                    <v-text-field
                        v-model="form.ref_obj_od"
                        :error-messages="errors.ref_obj_od"
                        title="Refracción Objetiva Ojo Derecho"
                        single-line
                        dense
                        solo
                    ></v-text-field>
                    <v-text-field
                        v-model="form.ref_obj_oi"
                        :error-messages="errors.ref_obj_oi"
                        title="Refracción Objetiva Ojo izquierdo"
                        single-line
                        dense
                        solo
                    ></v-text-field>
                </v-col>
                <!-- Tercera columna -->
                <v-col sm="1" cols="6" class="pt-3 pb-0">
                    <v-subheader class="pl-0 mt-4">OD*</v-subheader>
                    <v-subheader class="pl-0 mt-4">OI*</v-subheader>
                </v-col>
                <!-- Cuarta columna -->
                <v-col sm="2" cols="6" class="pt-3 pb-0">
                    <h5 class="pb-2">Refracción Subjetiva</h5>
                    <v-text-field
                        v-model="form.ref_sub_od"
                        :error-messages="errors.ref_sub_od"
                        title="Refracción Subjetiva Ojo Derecho"
                        single-line
                        dense
                        solo
                    ></v-text-field>
                    <v-text-field
                        v-model="form.ref_sub_oi"
                        :error-messages="errors.ref_sub_oi"
                        title="Refracción Subjetiva Ojo izquierdo"
                        single-line
                        dense
                        solo
                    ></v-text-field>
                </v-col>
                <!-- Quinta columna -->
                <v-col sm="1" cols="6" class="pt-3 pb-0" style="background-color: #f0f0f0; border-top-left-radius: 14px; border-bottom-left-radius: 14px;">
                    <v-subheader class="pl-0 mt-4">OD*</v-subheader>
                    <v-subheader class="pl-0 mt-4">OI*</v-subheader>
                </v-col>
                <!-- Sexta columna -->
                <v-col sm="2" cols="6" class="pt-3 pb-0" style="background-color: #f0f0f0; border-top-right-radius: 14px; border-bottom-right-radius: 14px;">
                    <h5 class="pb-2">Queratrometria</h5>
                    <v-text-field
                        v-model="form.que_od"
                        :error-messages="errors.que_od"
                        title="Queratometría Ojo Derecho"
                        single-line
                        dense
                        solo
                    ></v-text-field>
                    <v-text-field
                        v-model="form.que_oi"
                        :error-messages="errors.que_oi"
                        title="Queratometría Ojo Izquierdo"
                        single-line
                        dense
                        solo
                    ></v-text-field>
                </v-col>
                <!-- Septima columna -->
                <v-col sm="1" cols="6" class="pt-1 pb-0">
                    <v-subheader class="pl-0">Hirschberg</v-subheader>
                    <v-subheader class="pl-0">Cover Test</v-subheader>
                </v-col>
                <!-- Octava columna -->
                <v-col sm="2" cols="6" class="pt-1 pb-0">
                    <v-text-field
                        v-model="form.hirschberg"
                        :error-messages="errors.hirschberg"
                        title="Hirschberg"
                        single-line
                        dense
                    ></v-text-field>
                    <v-text-field
                        v-model="form.cover_test"
                        :error-messages="errors.cover_test"
                        title="Cover Test"
                        single-line
                        dense
                    ></v-text-field>
                </v-col>

            </v-row>
            <v-row class="ml-2 mr-2 mt-5">
                <v-col sm="1" cols="6" class="pt-0">
                    <v-subheader class="pl-0 mt-4">PPC:</v-subheader>
                </v-col>
                <!-- Segunda columna -->
                <v-col sm="2" cols="6" class="pt-0">
                    <v-text-field
                        v-model="form.ppc"
                        :error-messages="errors.ppc"
                        title="Punto Próximo de Convergencia"
                        single-line
                        dense
                    ></v-text-field>
                </v-col>
                <!-- Tercera columna -->
                <v-col sm="1" cols="6" class="pt-0">
                    <v-subheader class="pl-0 mt-4">Motilidad ocular</v-subheader>
                </v-col>
                <!-- Cuarta columna -->
                <v-col sm="2" cols="6" class="pt-0">
                    <v-text-field
                        v-model="form.motilidad_ocular"
                        :error-messages="errors.motilidad_ocular"
                        title="Motilidad ocular"
                        single-line
                        dense
                    ></v-text-field>
                </v-col>
                <!-- Quinta columna -->
                <v-col sm="1" cols="6" class="pt-0">
                    <v-subheader class="pl-0 mt-4">Dilatación Pupilar</v-subheader>
                </v-col>
                <!-- Sexta columna -->
                <v-col sm="2" cols="6" class="pt-0">
                    <v-text-field
                        v-model="form.dilatacion_pupilar"
                        :error-messages="errors.dilatacion_pupilar"
                        title="Dilatación Pupilar"
                        single-line
                        dense
                    ></v-text-field>
                </v-col>
                <!-- Septima columna -->
                <v-col sm="1" cols="6" class="pt-0">
                    <v-subheader class="pl-0 mt-4">Papilas</v-subheader>
                </v-col>
                <!-- Octava columna -->
                <v-col sm="2" cols="6" class="pt-0">
                    <v-text-field
                        v-model="form.papilas"
                        :error-messages="errors.papilas"
                        title="Papilas"
                        single-line
                        dense
                    ></v-text-field>
                </v-col>
            </v-row>

            <!-- BIOMICROSCOPIA -->
            <v-row class="ml-2 mr-2">
                <v-col sm="6" cols="12" style="border: solid 1px #000; border-radius:22px;">
                    <h5>BIOMICROSCOPIA OD:*</h5>
                    <v-row class="pt-4">
                        <v-col sm="4" cols="12" class="pt-0 pl-1 pr-1">
                            <v-text-field
                                v-model="form.bio_od_par"
                                :error-messages="errors.bio_od_par"
                                label="Parpados"
                                title="Parpados ojo derecho"
                                outlined
                                dense
                            ></v-text-field>
                            <v-text-field
                                v-model="form.bio_od_con"
                                :error-messages="errors.bio_od_con"
                                label="Conjuntiva"
                                title="Conjuntiva ojo derecho"
                                outlined
                                dense
                            ></v-text-field>
                            <v-text-field
                                v-model="form.bio_od_cor"
                                :error-messages="errors.bio_od_cor"
                                label="Cornea"
                                title="Cornea ojo derecho"
                                outlined
                                dense
                            ></v-text-field>
                        </v-col>
                        <v-col sm="4" cols="12" class="pt-0 pl-1 pr-1">
                            <v-text-field
                                v-model="form.bio_od_ang"
                                :error-messages="errors.bio_od_ang"
                                label="Angulo"
                                title="Angulo ojo derecho"
                                outlined
                                dense
                            ></v-text-field>
                            <v-text-field
                                v-model="form.bio_od_iris"
                                :error-messages="errors.bio_od_iris"
                                label="Iris"
                                title="Iris ojo derecho"
                                outlined
                                dense
                            ></v-text-field>
                            <v-text-field
                                v-model="form.bio_od_rpa"
                                :error-messages="errors.bio_od_rpa"
                                label="Reflejo Papilar"
                                title="Reflejo Papilar ojo derecho"
                                outlined
                                dense
                            ></v-text-field>
                        </v-col>
                        <v-col sm="4" cols="12" class="pt-0 pl-1 pr-1">
                            <v-text-field
                                v-model="form.bio_od_cri"
                                :error-messages="errors.bio_od_cri"
                                label="Cristalino"
                                title="Cristalino ojo derecho"
                                outlined
                                dense
                            ></v-text-field>
                            <v-text-field
                                v-model="form.bio_od_pro"
                                :error-messages="errors.bio_od_pro"
                                label="Presión Ocular"
                                title="Presión Ocular ojo derecho"
                                outlined
                                dense
                            ></v-text-field>
                        </v-col>
                    </v-row>
                </v-col>
                <v-col sm="6" cols="12" style="border: solid 1px #000; border-radius:22px;">
                    <h5>BIOMICROSCOPIA OI:*</h5>
                    <v-row class="pt-4">
                        <v-col sm="4" cols="12" class="pt-0 pl-1 pr-1">
                            <v-text-field
                                v-model="form.bio_oi_par"
                                :error-messages="errors.bio_oi_par"
                                title="Parpados ojo izquierdo"
                                label="Parpados"
                                outlined
                                dense
                            ></v-text-field>
                            <v-text-field
                                v-model="form.bio_oi_con"
                                :error-messages="errors.bio_oi_con"
                                title="Conjuntiva ojo izquierdo"
                                label="Conjuntiva"
                                outlined
                                dense
                            ></v-text-field>
                            <v-text-field
                                v-model="form.bio_oi_cor"
                                :error-messages="errors.bio_oi_cor"
                                title="Cornea ojo izquierdo"
                                label="Cornea"
                                outlined
                                dense
                            ></v-text-field>
                        </v-col>
                        <v-col sm="4" cols="12" class="pt-0 pl-1 pr-1">
                            <v-text-field
                                v-model="form.bio_oi_ang"
                                :error-messages="errors.bio_oi_ang"
                                title="Angulo ojo izquierdo"
                                label="Angulo"
                                outlined
                                dense
                            ></v-text-field>
                            <v-text-field
                                v-model="form.bio_oi_iris"
                                :error-messages="errors.bio_oi_iris"
                                title="Iris ojo izquierdo"
                                label="Iris"
                                outlined
                                dense
                            ></v-text-field>
                            <v-text-field
                                v-model="form.bio_oi_rpa"
                                :error-messages="errors.bio_oi_rpa"
                                title="Reflejo Papilar ojo izquierdo"
                                label="Reflejo Papilar"
                                outlined
                                dense
                            ></v-text-field>
                        </v-col>
                        <v-col sm="4" cols="12" class="pt-0 pl-1 pr-1">
                            <v-text-field
                                v-model="form.bio_oi_cri"
                                :error-messages="errors.bio_oi_cri"
                                title="Cristalino ojo izquierdo"
                                label="Cristalino"
                                outlined
                                dense
                            ></v-text-field>
                            <v-text-field
                                v-model="form.bio_oi_pro"
                                :error-messages="errors.bio_oi_pro"
                                title="Presión Ocular ojo izquierdo"
                                label="Presión Ocular"
                                outlined
                                dense
                            ></v-text-field>
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
                        <v-col sm="2" cols="6" class="pt-0">
                            <v-subheader class="pl-0">Papila</v-subheader>
                            <v-subheader class="pl-0">Macula</v-subheader>
                            <v-subheader class="pl-0">Vasos Retinales</v-subheader>
                        </v-col>
                        <v-col sm="4" cols="6" class="pt-0">
                            <v-text-field
                                v-model="form.fon_od_pap"
                                :error-messages="errors.fon_od_pap"
                                title="Papila ojo derecho"
                                dense
                            ></v-text-field>
                            <v-text-field
                                v-model="form.fon_od_mac"
                                :error-messages="errors.fon_od_mac"
                                title="Macula ojo derecho"
                                dense
                            ></v-text-field>
                            <v-text-field
                                v-model="form.fon_od_vre"
                                :error-messages="errors.fon_od_vre"
                                title="Vasos Retinales ojo derecho"
                                dense
                            ></v-text-field>
                        </v-col>
                        <v-col sm="2" cols="6" class="pt-0">
                            <v-subheader class="pl-0">Vitreo</v-subheader>
                            <v-subheader class="pl-0">Periferia</v-subheader>
                            <v-subheader class="pl-0">Retina</v-subheader>
                        </v-col>
                        <v-col sm="4" cols="6" class="pt-0">
                            <v-text-field
                                v-model="form.fon_od_vit"
                                :error-messages="errors.fon_od_vit"
                                title="Vitreo ojo derecho"
                                dense
                            ></v-text-field>
                            <v-text-field
                                v-model="form.fon_od_per"
                                :error-messages="errors.fon_od_per"
                                title="Periferia ojo derecho"
                                dense
                            ></v-text-field>
                            <v-text-field
                                v-model="form.fon_od_retina"
                                :error-messages="errors.fon_od_retina"
                                title="Retina ojo derecho"
                                dense
                            ></v-text-field>
                        </v-col>
                    </v-row>
                </v-col>
                <v-col sm="6" cols="12" style="border: solid 1px #000; border-radius:22px;">
                    <h5>OI:*</h5>
                    <v-row>
                        <v-col sm="2" cols="6" class="pt-0">
                            <v-subheader class="pl-0">Papila</v-subheader>
                            <v-subheader class="pl-0">Macula</v-subheader>
                            <v-subheader class="pl-0">Vasos Retinales</v-subheader>
                        </v-col>
                        <v-col sm="4" cols="6" class="pt-0">
                            <v-text-field
                                v-model="form.fon_oi_pap"
                                :error-messages="errors.fon_oi_pap"
                                title="Papila Ojo izquierdo"
                                dense
                            ></v-text-field>
                            <v-text-field
                                v-model="form.fon_oi_mac"
                                :error-messages="errors.fon_oi_mac"
                                title="Macula ojo izquierdo"
                                dense
                            ></v-text-field>
                            <v-text-field
                                v-model="form.fon_oi_vre"
                                :error-messages="errors.fon_oi_vre"
                                title="Vasos Retinales ojo izquierdo"
                                dense
                            ></v-text-field>
                        </v-col>
                        <v-col sm="2" cols="6" class="pt-0">
                            <v-subheader class="pl-0">Vitreo</v-subheader>
                            <v-subheader class="pl-0">Periferia</v-subheader>
                            <v-subheader class="pl-0">Retina</v-subheader>
                        </v-col>
                        <v-col sm="4" cols="6" class="pt-0">
                            <v-text-field
                                v-model="form.fon_oi_vit"
                                :error-messages="errors.fon_oi_vit"
                                title="Vitreo ojo derecho"
                                dense
                            ></v-text-field>
                            <v-text-field
                                v-model="form.fon_oi_per"
                                :error-messages="errors.fon_oi_per"
                                title="Periferia ojo izquierdo"
                                dense
                            ></v-text-field>
                            <v-text-field
                                v-model="form.fon_oi_retina"
                                :error-messages="errors.fon_oi_retina"
                                title="Retina ojo izquierdo"
                                dense
                            ></v-text-field>
                        </v-col>
                    </v-row>
                </v-col>
            </v-row>
            <v-row class="ml-1 mr-1 pt-4">
                <v-col cols="12" sm="6" class="pb-0">
                    <v-textarea
                        v-model="form.diagnostico"
                        :error-messages="errors.diagnostico"
                        rows="2"
                        outlined
                        label="Diagnostico"
                        ></v-textarea>
                </v-col>

                <v-col cols="12" sm="6"  class="pb-0">
                    <v-textarea
                        v-model="form.tratamiento"
                        :error-messages="errors.tratamiento"
                        rows="2"
                        outlined
                        label="Tratamiento"
                    ></v-textarea>
                </v-col>

                <v-col cols="12" sm="6" class="pb-0 pt-0">
                    <v-textarea
                        v-model="form.orden_medica"
                        :error-messages="errors.orden_medica"
                        rows="2"
                        outlined
                        label="Orden Medica"
                    >
                    </v-textarea>
                </v-col>
            </v-row>

            <v-row class="pl-4 pr-4">
                <!-- BOTONES ACCIONES  -->
                <v-col cols="12" sm="6">
                    <v-btn
                        type="submit"
                        small
                        color="red darken-4"
                        class="white--text text-none"
                        tile
                        v-on:click="fnImprimir('formula')"
                        v-if="cAccion == 'Actualizar'"
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
                        v-on:click="fnImprimir('orden_medica')"
                        v-if="cAccion == 'Actualizar'"
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
                        v-on:click="fnImprimir('rx')"
                        v-if="cAccion == 'Actualizar'"
                    >
                        Imprimir RX
                        <v-icon right> picture_as_pdf </v-icon>
                    </v-btn>
                </v-col>
                <v-col cols="12" sm="6" class="d-flex justify-end">
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
                    >
                        {{ cAccion }}
                        <v-icon right> save </v-icon>
                    </v-btn>
                </v-col>
            </v-row>
        </v-card>
        <!-- FIN FORMULARIO -->

        <!-- start Data table -->
        <v-row>
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
                >
                    <template v-slot:item.acciones="{ item }">
                        <v-icon
                            color="primary"
                            class="mr-2"
                            @click="fnShow(item.id)"
                            title="Editar Formula Anteojos"
                        >
                            mdi-pencil
                        </v-icon>
                        <v-icon
                            color="red"
                            title="Eliminar Formula Anteojos."
                            @click="fnDelete(item)"
                        >
                            mdi-delete
                        </v-icon>
                    </template>
                </v-data-table>
            </v-col>
        </v-row>
        <!-- end Data table -->
    </div>
</template>
<script>
import loadingGeneral from "../../loadingGeneral/loadingGeneral.vue";
export default {
    components: {
        loadingGeneral,
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
            errors:"",

            form: {
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
                papilas             : '',
                bio_od_par          : '',
                bio_od_ang          : '',
                bio_od_cri          : '',
                bio_od_con          : '',
                bio_od_iris         : '',
                bio_od_pro          : '',
                bio_od_cor          : '',
                bio_od_rpa          : '',
                bio_oi_par          : '',
                bio_oi_ang          : '',
                bio_oi_cri          : '',
                bio_oi_con          : '',
                bio_oi_iris         : '',
                bio_oi_pro          : '',
                bio_oi_cor          : '',
                bio_oi_rpa          : '',
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
                orden_medica        : ''
            }
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
                this.fnBuscar(this.buscar);
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
                    this.loading = false;
                    this.totalRegistros = response.data.total;

                    let data = response.data.data
                    this.form.numero_documento   = this.$route.params.numero_documento;
                    for (let i = 0; i < this.totalRegistros; i++) {
                        data[i].id_paciente      = data[i].get_paciente.id;
                        data[i].numero_documento = data[i].get_paciente.numero_documento;
                        data[i].nombre           = data[i].get_paciente.nombre;
                        data[i].apellido         = data[i].get_paciente.apellido;
                        delete data[i].get_paciente;
                    }

                    this.dataSet = data;

                    this.overlayLoading = false;
                    if (this.contador == 0) {
                        this.contador++;
                        this.fnObtenerNumeroFormulaAnteojos();
                    }

                })
                .catch((errors) => {
                    this.overlayLoading = false;
                    this.loading = false;
                    this.dataSet = [];
                });
        },
        fnObtenerNumeroFormulaAnteojos(){
            this.form.numero_documento = this.$route.params.numero_documento;
            this.overlayLoading = true;
            axios
                .get(`/consultorio-oftamologico/historia-clinica/cosecutivo-formula-anteojos/${this.form.numero_documento}`)
                .then((response) => {
                    this.numero_formula_anteojos = response.data;
                    this.overlayLoading = false;
                })
                .catch((errores) => {
                    this.fnResponseError(errores);
                    this.overlayLoading = false;
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
            this.form.numero_documento = this.$route.params.numero_documento;
            this.overlayLoading = true;
            axios
                .post(`/consultorio-oftamologico/historia-clinica/guardar/formula-anteojos`, this.form)
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
                    this.errors = this.fnResponseError(errores);
                    this.overlayLoading = false;
                });
        },
        fnUpdate(){
            this.overlayLoading = true;
            this.form.numero_documento = this.$route.params.numero_documento;
            axios
                .put(`/consultorio-oftamologico/historia-clinica/actualizar/formula-anteojos/${this.form.id}`, this.form)
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
                    this.errors = this.fnResponseError(errores);
                    this.overlayLoading = false;
                });
        },
        fnShow(id){
            this.overlayLoading = true;
            this.cAccion = "Actualizar";
            axios
                .get(`/consultorio-oftamologico/historia-clinica/mostrar/formula-anteojos/${id}`)
                .then((response) => {
                    let data = response.data.data;
                    this.form = data;
                    this.numero_formula_anteojos = data.numero_formula_anteojos;

                    this.errors = "";
                    this.overlayLoading = false;
                })
                .catch((errores) => {
                    this.errors = this.fnResponseError(errores);
                    this.overlayLoading = false;
                });
        },
        fnDelete(item){
            this.$swal({
            title: 'Quiere eliminar la Formula Anteojos?',
            text: `Eliminar la Formula Anteojos N°${item.numero_formula_anteojos}!`,
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
            this.errors = "";
            this.fnObtenerNumeroFormulaAnteojos();
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
            this.form.ref_obj_od          = '';
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
            this.form.papilas             = '';
            this.form.bio_od_par          = '';
            this.form.bio_od_ang          = '';
            this.form.bio_od_cri          = '';
            this.form.bio_od_con          = '';
            this.form.bio_od_iris         = '';
            this.form.bio_od_pro          = '';
            this.form.bio_od_cor          = '';
            this.form.bio_od_rpa          = '';
            this.form.bio_oi_par          = '';
            this.form.bio_oi_ang          = '';
            this.form.bio_oi_cri          = '';
            this.form.bio_oi_con          = '';
            this.form.bio_oi_iris         = '';
            this.form.bio_oi_pro          = '';
            this.form.bio_oi_cor          = '';
            this.form.bio_oi_rpa          = '';
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
        },
        fnImprimir(reporte = ''){
            this.overlayLoading = true;
            const data = {
                tipo_reporte    : reporte,
                numero_documento: this.$route.params.numero_documento,
                id_formula      : this.form.id
            };
            axios
                .post(`/consultorio-oftamologico/historia-clinica/pdf/formula-anteojos`,data,  {responseType: 'blob',})
                .then((response) => {
                    let hoy = new Date();
                    let fecha = hoy.getDate() +""+ ( hoy.getMonth() + 1 ) +""+  hoy.getFullYear();
                    let hora = hoy.getHours() +""+  hoy.getMinutes() +""+  hoy.getSeconds();
                    const nombrePDF = reporte+"_"+fecha+""+hora+".pdf";

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
        }
    }
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
