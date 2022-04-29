<template>
    <div>
        <loadingGeneral v-bind:overlayLoading="overlayLoading" />
        <!-- FORMULARIO -->
        <v-card elevation="2" class="mt-7">
            <v-row class="pl-4 pr-4 pt-5">
                <v-col cols="9" sm="9">

                    <v-row>
                        <v-col cols="6" sm="4" class="pb-2">
                            <v-text-field
                                type="date"
                                v-model="form.fecha"
                                ref="fecha"
                                label="Fecha Historia"
                                :error-messages="errors.fecha"
                                dense
                            ></v-text-field>
                        </v-col>
                        <v-col cols="6" sm="4" class="pb-2">
                            <v-text-field
                                type="time"
                                v-model="form.hora"
                                ref="hora"
                                label="Hora Historia"
                                :error-messages="errors.hora"
                                dense
                            ></v-text-field>
                        </v-col>
                    </v-row>

                    <v-row>
                        <v-col cols="4" sm="4" class="pb-2">
                            <v-text-field
                                v-model="numero_documento"
                                label="Número de Documento"
                                dense
                                readonly
                            ></v-text-field>
                        </v-col>
                        <v-col cols="4" sm="4" class="pb-2">
                            <v-text-field
                                v-model="nombre"
                                label="Nombre"
                                dense
                                readonly
                            ></v-text-field>
                        </v-col>
                        <v-col cols="4" sm="4" class="pb-2">
                            <v-text-field
                                v-model="apellido"
                                label="Apellido"
                                dense
                                readonly
                            ></v-text-field>
                        </v-col>
                    </v-row>

                    <v-row>
                        <v-col cols="12" sm="12">
                            <label for="id_refracciones">Subir Refracciones:</label>
                            <input type="file" id="id_refracciones" name="url_refraccion" accept="image/*" multiple style="width:50%;" title="Subir Refracciones, solo imagenes">
                        </v-col>
                        <v-col cols="12" sm="12">
                            <v-textarea
                                v-model="form.descripcion"
                                ref="descripcion"
                                label="Describa la Historia Clinica"
                                outlined
                                dense
                                :error-messages="errors.descripcion"
                                rows="2"
                                >
                            </v-textarea>
                        </v-col>
                    </v-row>
                </v-col>
                <v-col cols="3" sm="3" class="pb-2">
                    <v-card class="mx-auto" max-width="200">
                        <v-img
                            :src="(foto_paciente != null) ? foto_paciente : 'http://jago.co.nz/assets/camaleon_cms/image-not-found-4a963b95bf081c3ea02923dceaeb3f8085e1a654fc54840aac61a57a60903fef.png'"
                            height="150px" alt="Foto paciente">
                        </v-img>

                        <v-card-title>Foto Cliente</v-card-title>
                        </v-card>
                </v-col>
            </v-row>

            <v-row class="pl-4 pr-4">
                <!-- BOTONES ACCIONES  -->
                <v-col cols="12" class="d-flex justify-end">
                    <v-btn
                        type="submit"
                        small
                        color="red darken-4"
                        class="white--text text-none mr-3"
                        tile
                    >
                        <v-icon left> format_clear </v-icon>Limpiar
                    </v-btn>
                    <v-btn
                        type="submit"
                        small
                        color="success"
                        class="white--text text-none"
                        tile
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
                            title="Editar paciente"
                        >
                            mdi-pencil
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
            myFiles: ['cat.jpeg'] ,
            /* Variables Table. */
            buscar: "",
            page: 1,
            totalRegistros: 0,
            loading: false,
            overlayLoading : false,
            options: {},
            headers: [
                { text: "Historia Número", value: "numero_evolucion" },
                { text: "Fecha Historia", value: "fecha" },
                { text: "Hora Historia", value: "hora" },
                { text: "Fecha Modificado", value: "updated_at" },
                { text: "Acciones", value: "acciones", sortable: false },
            ],
            dataSet: [],

            /* VARIABLES FORMULARIO */
            form:{
                fecha : '',
                hora : '',
                refraccion : '',
                descripcion : ''
            },
            cAccion : 'Guardar',

            errors:{},

            foto_paciente    : null,
            numero_documento : '',
            nombre           : '',
            apellido         : '',
            /* FIN */

        }

    },
    methods:{
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
                sortBy = "";
                sortDesc = "";
            }

            axios
                .get(
                    `/consultorio-oftamologico/historia-clinica/buscar/evolucion/${this.$route.params.numero_documento}?length=${length}&start=${start}&orderColumn=${sortBy}&order=${sortDesc}`
                )
                .then((response) => {
                    this.loading = false;

                    let getDataPaciente = response.data.data[0].get_paciente;

                    if (getDataPaciente.foto != "") {
                        // Si la foto existe.
                        this.foto_paciente = "../../../"+getDataPaciente.foto;
                    }else{
                        // Si no existe.
                        this.foto_paciente = null;
                    }

                    this.numero_documento = getDataPaciente.numero_documento;
                    this.nombre = getDataPaciente.nombre;
                    this.apellido = getDataPaciente.apellido;

                    this.dataSet = response.data.data;
                    this.totalRegistros = response.data.total;

                    this.overlayLoading = false;
                })
                .catch((errors) => {
                    this.overlayLoading = false;
                    this.loading = false;
                    this.dataSet = [];
                    this.$swal({
                        icon: 'error',
                        title: `${errors.response.data.message}`,
                        text: `${errors.response.data.errors[0]}`,
                    })
                });
        },
        filterSearch() {
            this.overlayLoading = true;
            clearTimeout(this.debounce);
            this.debounce = setTimeout(() => {
                this.fnBuscar(this.buscar);
            }, 600);
        },
    },
    mounted(){
        this.fnBuscar();
    }
}
</script>
<style scope>

</style>
