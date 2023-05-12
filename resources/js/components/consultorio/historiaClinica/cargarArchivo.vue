
<template>
    <div>
        <loadingGeneral v-bind:overlayLoading="overlayLoading" />
        <!-- CargarArchivosController.php -->
        <v-card elevation="2" class="mt-7">
            <h3 class="text-center pt-2 pb-2">Carga Archivo - {{ consecutivo_archivo }}</h3>

            <v-row class="ml-2 mr-2">
                <v-col cols="6" sm="4" class="pb-2">
                    <v-text-field
                        v-model="numero_documento"
                        label="Número de Documento"
                        dense
                        readonly
                    ></v-text-field>
                </v-col>
                <v-col cols="6" sm="4" class="pb-2">
                    <v-text-field
                        v-model="nombre"
                        label="Nombre"
                        dense
                        readonly
                    ></v-text-field>
                </v-col>
                <v-col cols="6" sm="4" class="pb-2">
                    <v-text-field
                        v-model="apellido"
                        label="Apellido"
                        dense
                        readonly
                    ></v-text-field>
                </v-col>
            </v-row>

            <v-row class="ml-2 mr-2">
                <v-col cols="12" sm="6">
                    <div v-if="form.ruta_archivo == ''">
                        <label for="archivo">Cargar Archivo:</label>
                        <input type="file" id="archivo" accept="application/pdf" style="width:100%;">
                        <div style="color:#b71c1c;" class="pl-4" v-if="errors.ruta_archivo != undefined ">{{ errors.ruta_archivo[0] }}</div>
                    </div>
                    <div v-else>
                        Archivo Cargado:
                        <v-btn
                            type="submit"
                            small
                            color="red"
                            class="white--text text-none"
                            tile
                            v-on:click="fnDescargarArchivo"
                        >
                            Descargar
                            <v-icon right> picture_as_pdf </v-icon>
                        </v-btn>
                        <v-btn
                            type="click"
                            small
                            color="primary"
                            class="white--text text-none mr-3"
                            tile
                            v-on:click="form.ruta_archivo = ''">
                            Remover
                        </v-btn>
                    </div>
                </v-col>
                <v-col cols="12" sm="12">
                    <v-subheader>Consecutivo Archivo: {{ consecutivo_archivo }}</v-subheader>
                    <v-textarea
                        v-model="form.observacion"
                        ref="observacion"
                        label="Observación"
                        placeholder="Agregue aquí alguna observación para el Archivo a Cargar."
                        outlined
                        dense
                        :error-messages="errors.observacion"
                        rows="2"
                        >
                    </v-textarea>
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
                        :disabled="!$can(['LISTAR'])"
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
                    <template v-slot:item.editar="{ item }">
                        <v-icon
                            color="primary"
                            @click="fnShow(item.id)"
                            title="Editar Actecedente"
                            v-if="$can(['VER', 'EDITAR'])"
                        >
                            mdi-pencil
                        </v-icon>
                    </template>
                    <template v-slot:item.eliminar="{ item }">
                        <v-icon
                            color="red"
                            @click="fnDelete(item)"
                            title="Eliminar Actecedente"
                            v-if="$can(['ELIMINAR'])"
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
                { text: "Id Carga Archivo", value: "consecutivo_archivo" },
                { text: "Identificacion", value: "numero_documento", sortable: false },
                { text: "Observación", value: "observacion", sortable: false },
                { text: "Fecha Creación", value: "created_at" },
                { text: "Fecha Modificado", value: "updated_at" },
                { text: "Editar", value: "editar", sortable: false },
                { text: "Eliminar", value: "eliminar", sortable: false },
            ],
            dataSet: [],
            contador : 0,

            // Variables Formulario
            consecutivo_archivo     : '0000',
            cAccion                 : 'Guardar',
            errors:"",
            form : {
                id               : '',
                numero_documento : '',
                ruta_archivo     : '',
                observacion      : ''
            },
            numero_documento     : '',
            nombre               : '',
            apellido             : '',
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
                    `/consultorio-oftalmologico/historia-clinica/listar/cargar-archivo/${this.$route.params.numero_documento}?length=${length}&start=${start}&orderColumn=${sortBy}&order=${sortDesc}&buscar=${this.buscar}`
                )
                .then((response) => {
                    this.loading = false;
                    this.totalRegistros = response.data.total;

                    let data = response.data.data
                    let getDataPaciente   = data[0].get_paciente;
                    this.numero_documento = getDataPaciente.numero_documento;
                    this.nombre           = getDataPaciente.nombre;
                    this.apellido         = getDataPaciente.apellido;

                    this.form.numero_documento   = this.$route.params.numero_documento;
                    for (let i = 0; i < this.totalRegistros; i++) {
                        if ( data[i].observacion != null) {
                            data[i].observacion  = data[i].observacion.substr(0,15);
                        }
                        data[i].id_paciente      = data[i].get_paciente.id;
                        data[i].numero_documento = data[i].get_paciente.numero_documento;
                        delete data[i].get_paciente;
                    }

                    this.dataSet = data;

                    this.overlayLoading = false;
                    if (this.contador == 0) {
                        this.contador++;
                        this.obtenerConsecutivo();
                    }

                })
                .catch((errors) => {
                    this.overlayLoading = false;
                    this.loading = false;
                    this.dataSet = [];
                    this.fnResponseError(errors);
                });
        },
        obtenerConsecutivo(){
            this.form.numero_documento = this.$route.params.numero_documento;
            this.overlayLoading        = true;
            axios
                .get(`/consultorio-oftalmologico/historia-clinica/cosecutivo-cargar-archivo/${this.form.numero_documento}`)
                .then((response) => {
                    this.consecutivo_archivo = response.data;
                    this.overlayLoading      = false;
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
            this.overlayLoading = true;

            // files es una lista
            const formData  = new FormData()
            const files     = document.getElementById('archivo').files;
            if (files[0] == undefined) {
                formData.append('ruta_archivo', '');
            }else{
                formData.append('ruta_archivo', files[0]);
            }

            // Agregar archivo a formData, índice cero (primer archivo... o único)
            formData.append('observacion', this.form.observacion);
            formData.append('numero_documento', this.$route.params.numero_documento);

            axios
                .post(`/consultorio-oftalmologico/historia-clinica/guardar/cargar-archivo`,formData,{
                    headers: {
                        'Content-Type': 'multipart/form-data',
                        'Accept' : 'application/json'
                    },
                })
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

            const formData  = new FormData()
            if (this.form.ruta_archivo == "") {
                // files es una lista
                const files     = document.getElementById('archivo').files;
                if (files[0] == undefined) {
                    formData.append('ruta_archivo', '');
                }else{
                    formData.append('ruta_archivo', files[0]);
                }
            }else{
                formData.append('ruta_archivo', this.form.ruta_archivo);
            }
            formData.append('observacion', this.form.observacion);
            formData.append('numero_documento', this.$route.params.numero_documento);

            axios
                .post(`/consultorio-oftalmologico/historia-clinica/actualizar/cargar-archivo/${this.form.id}`, formData, {
                    headers: {
                        'Content-Type': 'multipart/form-data',
                        'Accept' : 'application/json'
                    },
                })
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
                .get(`/consultorio-oftalmologico/historia-clinica/mostrar/cargar-archivo/${id}`)
                .then((response) => {
                    let data = response.data.data;

                    this.form = data;
                    this.consecutivo_archivo = data.consecutivo_archivo;

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
            title: '¿Seguro que quiere eliminar el Archivo Cargado?',
            text: `Eliminar el Carga Archivo N°${item.consecutivo_archivo}!`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si, Eliminar!'
            }).then((result) => {
                if (result.isConfirmed) {

                    this.overlayLoading = true;

                    axios.post(`/consultorio-oftalmologico/historia-clinica/delete/cargar-archivo/${item.id}`)
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
        fnDescargarArchivo(){
            this.overlayLoading = true;

            let vRutaArchivo = this.form.ruta_archivo.split("/");
            const cNombreArchivo = vRutaArchivo[vRutaArchivo.length-1]; // Obteniendo ultima posicion de arreglo para el nombre de archivo.
            vRutaArchivo = vRutaArchivo.slice(0,-1);
            const cRuta  = vRutaArchivo.join('/');

            const data = {
                path          : cRuta+"/",
                nombreArchivo : cNombreArchivo
            };
            axios
                .post(`/consultorio-oftalmologico/historia-clinica/descargar/archivo`,data,  {responseType: 'blob',})
                .then((response) => {
                    const url = window.URL.createObjectURL(new Blob([response.data]))
                    const link = document.createElement('a')
                    link.href= url
                    link.setAttribute('download', cNombreArchivo)
                    document.body.appendChild(link)
                    link.click();

                    this.overlayLoading = false;
                })
                .catch((errores) => {
                    this.errors = this.fnResponseError(errores);
                    this.overlayLoading = false;
                });
        },
        limpiarCampos(){
            if (this.cAccion == "Guardar" || this.form.ruta_archivo == "") {
                // Solo se limpia campo donde se carga el archivo si esta por modo Guardar que es donde existe el campo input.
                document.getElementById('archivo').value = ""
            }
            this.errors                = "";
            this.obtenerConsecutivo();
            this.cAccion               = "Guardar";
            this.form.id               = '';
            this.form.numero_documento = '';
            this.form.observacion      = '';
            this.form.ruta_archivo     = '';
        }
    }
}
</script>
