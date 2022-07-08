<template>
    <div>
        <loadingGeneral v-bind:overlayLoading="overlayLoading" />
        <!-- FORMULARIO -->
        <v-card elevation="2" class="mt-7">
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
                    ></v-text-field>
                </v-col>
                <v-col cols="12" sm="3" class="pt-0">
                    <v-btn
                        color="success"
                        class="white--text"
                        @click="fnBuscarCitas()"
                        >Buscar</v-btn
                    >
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
                            <th class="text-left">Celular</th>
                            <th class="text-left">Tipo Consulta</th>
                            <th class="text-left">Asisitio</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="item in dataReporteCitas" :key="item.id">
                            <td>{{ item.hora_cita }}</td>
                            <td>{{ item.get_paciente.numero_documento }}</td>
                            <td>
                                {{ item.get_paciente.nombre }}
                                {{ item.get_paciente.apellido }}
                            </td>
                            <td>{{ item.get_paciente.celular }}</td>
                            <td>{{ item.tipo_consulta }}</td>
                            <td>
                                <input
                                    :name="'asisitio_'+item.id"
                                    type="checkbox"
                                    :checked="item.asistio == 'SI' ? true : false"
                                    @change="fnAsistioCita(item.id)"
                                    :id="'asisitio_'+item.id">
                                <label :for="'asisitio_'+item.id"></label>
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
        };
    },
    methods: {
        fnBuscarCitas() {
            const data = {
                tipo_informe_cita: this.radioGroupReporte,
                fecha_reporte: this.form.fecha_reporte,
            };
            this.overlayLoading = true;
            axios
                .post(
                    `/consultorio-oftamologico/agenda/informe-cita/listar`,
                    data
                )
                .then((response) => {
                    this.dataReporteCitas = response.data.data;
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
        fnAsistioCita(id_cita) {
            this.overlayLoading = true;
            axios
                .post(
                    `/consultorio-oftamologico/agenda/informe-cita/asistio-cita/${id_cita}`
                )
                .then((response) => {
                    this.$swal(
                        response.data.message,
                        '',
                        'success'
                    );
                    this.fnBuscarCitas();
                })
                .catch((errores) => {
                    this.fnResponseError(errores);
                })
                .finally(() => (this.overlayLoading = false));
        },
    },
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
    width: 1.2em;
    height: 1.2em;
    padding-left: 0.2em;
    padding-bottom: 0.3em;
    margin-right: 0.2em;
    vertical-align: bottom;
    color: transparent;
    transition: 0.2s;
}

input[type="checkbox"] + label:active:before {
    transform: scale(0);
}

input[type="checkbox"]:checked + label:before {
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
