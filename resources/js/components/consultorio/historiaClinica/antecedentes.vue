<template>
    <div>
        <loadingGeneral v-bind:overlayLoading="overlayLoading" />
        <!-- FORMULARIO -->
        <v-card elevation="2" class="mt-7">
            <h3 class="text-center pt-2 pb-2">Antecedente - {{ numero_antecedente }}</h3>
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
                <v-col cols="12" class="d-flex justify-end">
                    <v-btn
                        type="submit"
                        color="yellow"
                        class="text-none mr-3"
                        title="Vacía campos del formulario para crear nuevo antecedente."
                        tile
                        @click="limpiarCampos"
                    >
                        <v-icon left> format_clear </v-icon>Limpiar
                    </v-btn>
                    <v-btn
                        type="submit"
                        color="success"
                        class="white--text text-none"
                        tile
                        v-on:click="fnAccion"
                    >
                        {{ cAccion }}
                        <v-icon right> save </v-icon>
                    </v-btn>
                </v-col>
                <pre>
                    {{
                        errors
                    }}
                </pre>
            </v-row>
        </v-card>
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
                    <template v-slot:item.editar="{ item }">
                        <v-icon
                            color="primary"
                            @click="fnShow(item.id)"
                            title="Editar Actecedente"
                        >
                            mdi-pencil
                        </v-icon>
                    </template>
                    <template v-slot:item.eliminar="{ item }">
                        <v-icon
                            color="red"
                            @click="fnDelete(item)"
                            title="Eliminar Actecedente"
                        >
                            delete
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
                { text: "Id Antecedente", value: "numero_antecedente" },
                { text: "Identificacion", value: "numero_documento", sortable: false },
                { text: "Nombre", value: "nombre", sortable: false },
                { text: "Apellidos", value: "apellido", sortable: false },
                { text: "Fecha Creación", value: "created_at" },
                { text: "Fecha Modificado", value: "updated_at" },
                { text: "Editar", value: "editar", sortable: false },
                { text: "Eliminar", value: "eliminar", sortable: false },
            ],
            dataSet: [],
            contador : 0,

            // Formulario
            numero_antecedente      : '0000',
            cAccion                 : 'Guardar',
            errors:"",
            form : {
                id               : '',
                numero_documento : '',
                antecedentes     : [],
                otro             : ''
            },

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
    methods: {
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
                    `/consultorio-oftamologico/historia-clinica/listar/antecedentes/${this.$route.params.numero_documento}?length=${length}&start=${start}&orderColumn=${sortBy}&order=${sortDesc}&buscar=${this.buscar}`
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
                        this.fnObtenerNumeroAntecedente();
                    }

                })
                .catch((errors) => {
                    this.overlayLoading = false;
                    this.loading = false;
                    this.dataSet = [];
                });
        },
        fnObtenerNumeroAntecedente(){
            this.form.numero_documento = this.$route.params.numero_documento;
            this.overlayLoading = true;
            axios
                .get(`/consultorio-oftamologico/historia-clinica/cosecutivo-antecedentes/${this.form.numero_documento}`)
                .then((response) => {
                    this.numero_antecedente = response.data;
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
            this.form.antecedentes = this.form.antecedentes.toString();
            this.overlayLoading = true;
            axios
                .post(`/consultorio-oftamologico/historia-clinica/guardar/antecedentes`, this.form)
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
            this.form.antecedentes = this.form.antecedentes.toString();
            axios
                .put(`/consultorio-oftamologico/historia-clinica/actualizar/antecedentes/${this.form.id}`, this.form)
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
                .get(`/consultorio-oftamologico/historia-clinica/mostrar/antecedentes/${id}`)
                .then((response) => {
                    let data = response.data.data;
                    data.antecedentes = data.antecedentes.split(',');

                    this.form = data;
                    this.numero_antecedente = data.numero_antecedente;

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
            title: '¿Seguro que quiere eliminar el Antecedente?',
            text: `Eliminar el Antecedente N°${item.numero_antecedente}!`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si, Eliminar!'
            }).then((result) => {
                if (result.isConfirmed) {

                    this.overlayLoading = true;

                    axios.post(`/consultorio-oftamologico/historia-clinica/delete/antecedentes/${item.id}`)
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
            this.errors                = "";
            this.fnObtenerNumeroAntecedente();
            this.cAccion               = "Guardar";
            this.form.id               = '',
            this.form.numero_documento = '',
            this.form.antecedentes     = [],
            this.form.otro             = ''
        }
    }
}
</script>
