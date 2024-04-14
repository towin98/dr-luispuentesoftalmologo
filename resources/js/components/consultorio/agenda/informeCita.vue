<template>
    <div>
        <loadingGeneral v-bind:overlayLoading="overlayLoading" />
        <!-- FORMULARIO -->
        <v-card elevation="2" class="negativovMarginTopImprimir">
            <h3 class="text-center pt-2 pb-2">Informe de citas</h3>

            <v-row class="ml-2 mr-2">
                <v-col cols="6" class="pt-0 pb-0">
                    <v-radio-group v-model="radioGroupReporte" row>
                        <v-radio label="Por día" value="DIA"></v-radio>
                    </v-radio-group>
                </v-col>
            </v-row>

            <v-row class="ml-2 mr-2">
                <v-col cols="12" sm="3" class="pt-0">
                    <v-text-field
                        type="date"
                        v-model="form.fecha_reporte"
                        ref="fecha_reporte"
                        label="Fecha de reporte"
                        :error-messages="errors.fecha_reporte"
                        dense
                        :disabled="!$can(['LISTAR'])"
                    ></v-text-field>
                </v-col>
                <v-col cols="12" sm="3" class="pt-0">
                    <v-btn
                        color="success"
                        class="white--text"
                        @click="fnBuscarCitas()"
                        :disabled="!$can(['LISTAR'])"
                    >
                        Buscar
                    </v-btn>
                </v-col>
            </v-row>
            <v-divider></v-divider>
            <h3 class="text-center pt-2 pb-2">Reporte {{ fecha_title }}</h3>
            <v-simple-table>
                <template v-slot:default>
                    <thead>
                        <tr>
                            <th class="text-left">Hora</th>
                            <th class="text-left">Identificación</th>
                            <th class="text-left">Paciente</th>
                            <th class="text-left">Particular o MP</th>
                            <!-- <th class="text-left">Celular</th> -->
                            <th class="text-left">Tipo Consulta</th>
                            <th class="text-left">Asisitio</th>
                            <th class="text-left">Prioritario</th>
                            <th class="text-left">Seguir</th>
                            <th class="text-left">Valor</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(item,i) in dataReporteCitas" :key="i">
                            <td>{{ item.hora_cita }}</td>
                            <td>{{ item.get_paciente.numero_documento }}</td>
                            <td>
                                {{ item.get_paciente.nombre }}
                                {{ item.get_paciente.apellido }}
                            </td>
                            <td>{{ item.get_paciente.get_eps.descripcion }}</td>
                            <!-- <td>{{ item.get_paciente.celular }}</td> -->
                            <td>{{ item.tipo_consulta }}</td>
                            <td>
                                <input
                                    class="checkAsisitio"
                                    :name="'asisitio_'+item.id"
                                    type="checkbox"
                                    :checked="item.asistio == 'SI' ? true : false"
                                    @change="fnAsistioCita(item, i)"
                                    :id="'asisitio_'+item.id">
                                <label :for="'asisitio_'+item.id"></label>
                            </td>
                            <td>
                                <input
                                    class="checkPrioritario"
                                    :name="'prioritario_'+item.id"
                                    type="checkbox"
                                    :checked="item.prioridad == 'SI' ? true : false"
                                    @change="fnCitaPrioritaria(item, i)"
                                    :id="'prioritario_'+item.id">
                                <label :for="'prioritario_'+item.id"></label>
                            </td>
                            <td v-if="item.prioridad == 'SI'">{{ item.prioridad_aceptado == null ? 'NO AUTORIZADO' : 'AUTORIZADO' }}</td>
                            <td v-else></td>
                            <td :id="'tdValor_'+item.id">
                                <input
                                    style="border: green solid 1px;width: 110px; text-align: center;"
                                    class="rounded-pill"
                                    :name="'valorCita_'+item.id"
                                    :id="'valorCita_'+item.id"
                                    :value="fnFormatoValuePeso(item.valor)"
                                    @change="fnValorCita(item.id)"
                                    title="Valor Cita.">
                            </td>
                        </tr>
                        <tr>
                            <td colspan="8"></td>
                            <td>
                                TOTAL : {{ valorTotalRecaudado }}
                            </td>
                        </tr>
                    </tbody>
                </template>
            </v-simple-table>
        </v-card>
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
            overlayLoading: false,
            radioGroupReporte: "DIA",
            fecha_title : '',
            dataReporteCitas: [],

            // FORM
            form: {
                fecha_reporte: "",
            },
            errors: "",
            intervalIdBuscarCitas : 0,
            valorTotalRecaudado: 0
        };
    },
    methods: {
        fnBuscarCitas(loading = true) {
            clearInterval(this.intervalIdBuscarCitas);
            const data = {
                tipo_informe_cita: this.radioGroupReporte,
                fecha_reporte: this.form.fecha_reporte,
            };

            if (loading == true )this.overlayLoading = true;

            axios
                .post(`/consultorio-oftalmologico/agenda/informe-cita/listar`,data)
                .then((response) => {
                    this.dataReporteCitas = response.data.data;
                    this.fnSumarTotalRecaudado();

                    for (let index = 0; index < this.dataReporteCitas.length; index++) {
                        if (this.dataReporteCitas[index].prioridad == "SI") {
                            this.fnActivarSetIntervalBuscarCitar();
                            break;
                        }
                    }
                    this.errors = "";

                    let date = new Date(this.form.fecha_reporte.replace(/-+/g, '/'));

                    let options = {
                        weekday: 'long',
                        year: 'numeric',
                        month: 'long',
                        day: 'numeric'
                    };

                    this.fecha_title = " - " + date.toLocaleDateString('es-MX', options);
                })
                .catch((errores) => {
                    this.errors = this.fnResponseError(errores);
                    this.dataReporteCitas = [];
                })
                .finally(() => (this.overlayLoading = false));
        },
        fnAsistioCita(item, index) {
            this.overlayLoading = true;
            axios
                .post(
                    `/consultorio-oftalmologico/agenda/informe-cita/marcar/${item.id}`, {tipo_marcacion: 'ASISTIOCITA'}
                )
                .then((response) => {
                    this.dataReporteCitas[index].asistio = item.asistio == 'SI' ? 'NO' : 'SI';
                })
                .catch((errores) => {
                    this.fnResponseError(errores);
                })
                .finally(() => (this.overlayLoading = false));
        },
        fnCitaPrioritaria(item, index) {
            this.overlayLoading = true;
            let data = {};
            data = {
                tipo_marcacion: 'PRIORITARIA'
            };

            // id_alerta_cita igual a null si el paciente no tiene cita
            if (item.id_alerta_cita == null || item.id_alerta_cita == "") {
                data.tipo_alerta = 'PRIORITARIA'; // DATA PARA ALERTA
            }

            axios
                .post(`/consultorio-oftalmologico/agenda/informe-cita/marcar/${item.id}`, data)
                .then((response) => {
                    const valorCitaPrioritaria = item.prioridad == 'SI' ? 'NO' : 'SI';
                    if (valorCitaPrioritaria == "SI") {
                        clearInterval(this.intervalIdBuscarCitas);
                        this.fnActivarSetIntervalBuscarCitar();
                    }
                    this.dataReporteCitas[index].prioridad = valorCitaPrioritaria;

                    let citasPrioritariasExistentes = false;
                    for (let index = 0; index < this.dataReporteCitas.length; index++) {
                        if (this.dataReporteCitas[index].prioridad == "SI") {
                            citasPrioritariasExistentes = true;
                        }
                    }

                    if (citasPrioritariasExistentes == false) {
                        clearInterval(this.intervalIdBuscarCitas);
                    }
                })
                .catch((errores) => {
                    this.fnResponseError(errores);
                })
                .finally(() => (this.overlayLoading = false));
        },
        fnActivarSetIntervalBuscarCitar(){
            this.intervalIdBuscarCitas = setInterval(() => {
                this.fnBuscarCitas(false);
            }, 90000); // 1.5 min
        },
        fnValorCita(id){
            this.overlayLoading = true;
            let valor = document.getElementById('valorCita_'+id);
            const valorCita = this.fnReemplazarPuntosYComasPorPuntos(valor.value);

            let id_mensaje_valor = document.getElementById('id_mensaje_valor_'+id);

            axios
                .post(`/consultorio-oftalmologico/agenda/informe-cita/valor-cita/${id}`, {valor: valorCita})
                .then((response) => {
                    if (id_mensaje_valor) {
                        id_mensaje_valor.remove();
                    }

                    this.fnBuscarCitas(false);
                })
                .catch((errores) => {
                    if (id_mensaje_valor) {
                        id_mensaje_valor.remove();
                    }
                    document.getElementById('valorCita_'+id).value = "";
                    const div = document.createElement("div");
                    div.id = "id_mensaje_valor_"+id;

                    const span = document.createElement("span");
                    span.textContent = errores.response.data.errors.valor[0];
                    span.style.color = "red";
                    div.appendChild(span);

                    const tdValor = document.getElementById('tdValor_'+id);
                    tdValor.appendChild(div);
                })
                .finally(() => (this.overlayLoading = false));
        },
        /**
         * Método que formatea el valor de la cita.
         *
         * @param {number} id Id de la cita para armar el nombre del input.
         */
        fnFormatoValuePeso(valor){
            const formatterPeso = new Intl.NumberFormat('es-CO', {
                style: 'currency',
                currency: 'COP',
                minimumFractionDigits: 0
            });

            return formatterPeso.format(valor);
        },
        fnReemplazarPuntosYComasPorPuntos(cadena){
            let cadenaNueva = cadena.replace(/\$/g, '');
            cadenaNueva = cadenaNueva.replace(/\s+/g, '')
            cadenaNueva = cadenaNueva.replace(/\./g, '');
            return cadenaNueva.replace(/,/g, '.');
        },
        fnSumarTotalRecaudado(){
            this.valorTotalRecaudado = 0;
            let valorTotal = 0;
            for (let i = 0; i < this.dataReporteCitas.length; i++) {
                valorTotal += this.dataReporteCitas[i].valor;
            }

            this.valorTotalRecaudado = this.fnFormatoValuePeso(valorTotal);
        }
    },
    async created(){
    },
    destroyed() {
        clearInterval(this.intervalIdBuscarCitas);
    }
};
</script>
<style>
    input[type="checkbox"] + label {
        display: block;
        margin: 0.2em;
        cursor: pointer;
        padding: 0.2em;
        font-family: "Arial";
    }

    input[type="checkbox"] {
        display: none;
    }

    input[type="checkbox"] + label:before {
        content: "\2714";
        border: 0.1em solid #000;
        border-radius: 0.2em;
        display: inline-block;
        width: 1.5em;
        height: 1.5em;
        padding-left: 0.3em;
        padding-bottom: 1.3em;
        margin-right: 0.2em;
        vertical-align: bottom;
        color: transparent;
        transition: 0.2s;
    }

    input[type="checkbox"] + label:active:before {
        transform: scale(0);
    }

    .checkPrioritario:checked + label:before{
        background-color: #df1f1f;
        border-color: #df1f1f;
        color: #fff;
    }

    .checkAsisitio:checked + label:before {
        background-color: #4caf50;
        border-color: #4caf50;
        color: #fff;
    }

    input[type="checkbox"]:disabled + label:before {
        transform: scale(1);
        border-color: #aaa;
    }

    input[type="checkbox"]:checked:disabled + label:before {
        transform: scale(1);
        background-color: #a2d4a4;
        border-color: #a2d4a4;
    }
</style>
