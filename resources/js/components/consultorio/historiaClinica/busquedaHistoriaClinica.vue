<template>
    <div>
        <loadingGeneral v-bind:overlayLoading="overlayLoading"/>

        <v-row class="pt-7">
            <v-col cols="12" sm="9">

                <!-- Campos de busqueda paciente -INICIO -->
                <v-row>
                    <v-col cols="6" sm="3" class="pt-0 pb-2">
                        <v-select
                            v-model="form.tipo_documento"
                            ref="tipo_documento"
                            label="Tipo de Documento"
                            :items="tiposDocumentos"
                            item-value="value"
                            item-text="text"
                            :error-messages="errors.tipo_documento"
                            dense
                        ></v-select>
                    </v-col>
                    <v-col cols="6" sm="3" class="pt-0 pb-2">
                        <v-text-field
                            v-model="form.numero_documento"
                            label="Numero de Documento"
                            ref="numero_documento"
                            :error-messages="errors.numero_documento"
                            dense
                        ></v-text-field>
                    </v-col>
                    <v-col cols="6" sm="3" class="pt-0 pb-2">
                        <v-text-field
                            v-model="form.nombre"
                            label="Nombre Completo"
                            ref="nombre"
                            :error-messages="errors.nombre"
                            dense
                        ></v-text-field>
                    </v-col>
                    <v-col cols="6" sm="3" class="pt-0 pb-2">
                        <v-text-field
                            v-model="form.apellido"
                            label="Apellido Completo"
                            ref="apellido"
                            :error-messages="errors.apellido"
                            dense
                        ></v-text-field>
                    </v-col>
                </v-row>
                <!-- Campos de busqueda paciente -FIN -->

            </v-col>
            <v-col cols="12" sm="3" class="d-flex justify-center">
                <v-btn style="background:#616161;" class="white--text" @click="fnBuscarListarTodos()">Listar Todos</v-btn>
            </v-col>
        </v-row>

        <v-btn color="success" class="white--text" @click="fnBuscar()">Buscar</v-btn>

        <!-- start Data table -->
        <v-row class="mt-3">
            <v-col cols="12">
                <v-data-table
                    :page="page"
                    :pageCount="numberOfPages"
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
                    <template v-slot:item.historia_clinica="{ item }">
                        <router-link style="text-decoration: none;"
                            title="Historia clinica"
                            :to="{ path: `/consultorio/historia-clinica/formula-anteojos/${item.numero_documento}`, params: {numero_documento: item.numero_documento}}">
                            <v-icon color="light-green">
                                fact_check
                            </v-icon>
                        </router-link>
                    </template>
                    <template v-slot:item.cargarArchivo="{ item }">
                        <router-link style="text-decoration: none;"
                            title="Cargar archivo"
                            :to="{ path: `/consultorio/historia-clinica/cargar-archivo/${item.numero_documento}`, params: {numero_documento: item.numero_documento}}">
                            <v-icon color="grey">
                                file_upload
                            </v-icon>
                        </router-link>
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
    components : {
        loadingGeneral
    },
    data() {
        return {
            overlayLoading      : false,

            form: {
                tipo_documento: "",
                numero_documento : "",
                nombre: "",
                apellido: ""
            },

            tiposDocumentos: [
                { value: "CC", text: "CEDULA DE CIUDADANIA" },
                { value: "RC", text: "REGISTRO CIVIL" },
                { value: "CE", text: "CEDULA DE EXTRANJERIA" },
                { value: "NIP", text: "NUMERO DE IDENTIFICACION PERSONAL" },
                { value: "NIT", text: "NUMERO DE IDENTIFICACION TRIBUTARIA" },
                { value: "TI", text: "TARJETA DE IDENTIDAD" },
                { value: "PAP", text: "PASAPORTE" },
            ],

            errors: {},

            /* Variables Table. */
            // Tabla filtro.
            debounce: null,
            // Table listar
            page: 1,
            totalRegistros: 0,
            numberOfPages: 0,
            loading: false,
            options: {},
            headers: [
                { text: "Identificación", value: "numero_documento" },
                { text: "Nombre Completo", value: "nombre" },
                { text: "Apellido Completo", value: "apellido" },
                { text: "Fecha Modificado", value: "updated_at" },
                { text: "Historia Clinica", value: "historia_clinica", sortable: false, width:20 },
                { text: "Cargar Archivo", value: "cargarArchivo", sortable: false, width:20 },
            ],
            dataSet: [],
            contador: 0
        }
    },
    methods :{
        fnBuscar() {

            this.overlayLoading = true;
            this.loading = true;

            // Contruyendo data request enviar por get.
            let dataRequest = "";
            for (let key in this.form) {
                dataRequest += "&"+key+"="+this.form[key]
            }

            let { page, itemsPerPage, sortBy, sortDesc } = this.options;

            // Obteniendo rangos de consultado paginación.
            this.start  = itemsPerPage * (page - 1);
            this.length = itemsPerPage;

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
                    `/consultorio-oftalmologico/historia-clinica/buscar?length=${this.length}&start=${this.start}&orderColumn=${sortBy}&order=${sortDesc}${dataRequest}`
                )
                .then((response) => {
                    this.loading = false;
                    this.dataSet = response.data.data;
                    this.totalRegistros = response.data.total;
                    this.numberOfPages = response.data.totalPages;

                    this.overlayLoading = false;
                })
                .catch((errores) => {
                    this.overlayLoading = false;
                    this.loading = false;
                    this.dataSet = [];
                    this.errors = this.fnResponseError(errores);
                });
        },
        fnBuscarListarTodos(){
            this.overlayLoading = true;
            this.loading = true;

            // Limpiando campos porque se requiere listar todos los datos.
            this.limpiarCampo();

            // Contruyendo data request enviar por get.
            const dataRequest = "&listar_todos=SI";

            let { page, itemsPerPage, sortBy, sortDesc } = this.options;

            // Obteniendo rangos de consultado paginación.
            this.start  = itemsPerPage * (page - 1);
            this.length = itemsPerPage;

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
                    `/consultorio-oftalmologico/historia-clinica/buscar?length=${this.length}&start=${this.start}&orderColumn=${sortBy}&order=${sortDesc}${dataRequest}`
                )
                .then((response) => {
                    this.loading = false;
                    this.dataSet = response.data.data;
                    this.totalRegistros = response.data.total;
                    this.numberOfPages = response.data.totalPages;

                    this.overlayLoading = false;
                })
                .catch((errores) => {
                    this.overlayLoading = false;
                    this.loading = false;
                    this.dataSet = [];
                    this.errors = this.fnResponseError(errores);
                });
        },
        limpiarCampo() {
            this.form.tipo_documento    = "";
            this.form.numero_documento  = "";
            this.form.nombre            = "";
            this.form.apellido          = "";
        }
    },
    mounted(){
        this.fnBuscarListarTodos();
    }

}
</script>
