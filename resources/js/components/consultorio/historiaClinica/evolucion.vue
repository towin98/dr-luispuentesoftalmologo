<template>
    <div>
        <loadingGeneral v-bind:overlayLoading="overlayLoading" />
        <!-- FORMULARIO -->
        <v-card elevation="2" class="mt-7">
            <v-row class="pl-4 pr-4 pt-5">
                <v-col cols="12" sm="9">

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
                            <div v-if="url_refraccion == ''">
                                <label for="id_refracciones">Subir Refracciones:</label>
                                <input type="file" id="inputArchivos" accept="image/*" multiple style="width:50%;" title="Subir Refracciones, solo imagenes">
                                <div style="color:#b71c1c;" v-if="errors.url_refraccion != undefined ">{{ errors.url_refraccion[0] }}</div>
                            </div>
                            <div v-else>
                                Refracción:
                                <v-btn
                                    type="submit"
                                    small
                                    color="red"
                                    class="white--text text-none"
                                    tile
                                    v-on:click="fnDescargarRefraccion"
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
                                    v-on:click="url_refraccion = ''">
                                    Remover
                                </v-btn>
                            </div>
                        </v-col>
                        <v-col cols="12" sm="12">
                            <v-subheader>Historia No. {{ numero_evolucion }}</v-subheader>
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
                <v-col cols="12" sm="3" class="pb-2 pt-0">
                    <v-card class="mx-auto" max-width="200">
                        <v-img
                            :src="(foto_paciente != null) ? foto_paciente : '/img/sistema/image_not_found.png'"
                            height="150px" alt="Foto paciente">
                        </v-img>

                        <v-card-title><h6>Foto Cliente</h6></v-card-title>
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
                            @click="fnShowEvolucion(item.id)"
                            title="Editar Evolución"
                        >
                            mdi-pencil
                        </v-icon>
                        <v-icon
                            small
                            title="Eliminar Evolucion Seleccionada."
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
                descripcion : ''
            },
            cAccion : 'Guardar',

            errors:{},

            id_paciente      : '',
            foto_paciente    : null,
            numero_documento : '',
            nombre           : '',
            apellido         : '',
            numero_evolucion : '',
            url_refraccion   : '',
            /* FIN */

            contador : 0,
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
        fnAccion(){
            if (this.cAccion === "Guardar") {
                this.fnStore();
            }else{
                this.fnUpdate();
            }
        },
        fnStore(){
            this.overlayLoading = true;
            const $inputArchivos = document.querySelector("#inputArchivos");
            const archivosParaSubir = $inputArchivos.files;

            let formData = new FormData();
            for (let key in this.form) {
                if (this.form[key] == null) {
                    this.form[key] = '';
                }
                formData.append(key, this.form[key]);
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
                .post(`/consultorio-oftamologico/historia-clinica/guardar/evolucion`, formData, {
                    headers: {
                        'Content-Type': 'multipart/form-data'
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
        fnShowEvolucion(id){
            this.overlayLoading = true;
            this.cAccion = "Actualizar";
            axios
                .get(`/consultorio-oftamologico/historia-clinica/mostrar/evolucion/${id}`)
                .then((response) => {
                    let data = response.data.data;

                    this.form.fecha       = data.fecha;
                    this.form.hora        = data.hora;
                    this.form.descripcion = data.descripcion;
                    this.id               = data.id;
                    this.numero_evolucion = data.numero_evolucion;
                    this.url_refraccion   = data.url_refraccion;

                    this.errors = "";
                    this.overlayLoading = false;
                })
                .catch((errores) => {
                    this.errors = this.fnResponseError(errores);
                    this.overlayLoading = false;
                });
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
        fnUpdate(){
            this.overlayLoading = true;

            let formData = new FormData();
            for (let key in this.form) {
                if (this.form[key] == null) {
                    this.form[key] = '';
                }
                formData.append(key, this.form[key]);
            }
            formData.append('numero_documento', this.numero_documento);

                        // Si url_refraccion es vacio es porque se esta mostrando el input para subir archivos
            if (this.url_refraccion == "") {
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
                .post(`/consultorio-oftamologico/historia-clinica/actualizar/evolucion/${this.id}`, formData, {
                    headers: {
                        'Content-Type': 'multipart/form-data'
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
        fnHistoriaNumero(){
            this.overlayLoading = true;
            axios
                .get(`/consultorio-oftamologico/historia-clinica/numero-evolucion/${this.id_paciente}`)
                .then((response) => {
                    this.numero_evolucion = response.data;
                    this.overlayLoading = false;
                })
                .catch((errores) => {
                    this.errors = this.fnResponseError(errores);
                    this.overlayLoading = false;
                });
        },
        fnDelete(item){

            this.$swal({
            title: 'Quiere eliminar la Historia?',
            text: `Se removera la Historia No.${item.numero_evolucion}!`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si, Eliminar!'
            }).then((result) => {
                if (result.isConfirmed) {

                    this.overlayLoading = true;

                    axios.post(`/consultorio-oftamologico/historia-clinica/delete/evolucion/${item.id}`)
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

                }
            });
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
                sortBy = "";
                sortDesc = "";
            }

            axios
                .get(
                    `/consultorio-oftamologico/historia-clinica/buscar/evolucion/${this.$route.params.numero_documento}?length=${length}&start=${start}&orderColumn=${sortBy}&order=${sortDesc}&buscar=${this.buscar}`
                )
                .then((response) => {
                    this.loading = false;

                    let getDataPaciente = response.data.data[0].get_paciente;

                    if (getDataPaciente.foto != "") {
                        // Si la foto existe.
                        this.foto_paciente = "/"+getDataPaciente.foto;
                    }else{
                        // Si no existe.
                        this.foto_paciente = null;
                    }

                    this.id_paciente = getDataPaciente.id;
                    this.numero_documento = getDataPaciente.numero_documento;
                    this.nombre = getDataPaciente.nombre;
                    this.apellido = getDataPaciente.apellido;

                    this.dataSet = response.data.data;
                    this.totalRegistros = response.data.total;

                    this.overlayLoading = false;
                    if (this.contador == 0) {
                        this.contador++;
                        this.fnHistoriaNumero();
                    }

                })
                .catch((errors) => {
                    this.overlayLoading = false;
                    this.loading = false;
                    this.dataSet = [];
                    this.$swal({
                        icon: 'error',
                        title: ``,
                        text: `No fue posible realizar la operación solicitada`,
                    });
                });
        },
        filterSearch() {
            this.overlayLoading = true;
            clearTimeout(this.debounce);
            this.debounce = setTimeout(() => {
                this.fnBuscar(this.buscar);
            }, 600);
        },
        limpiarCampos(){
            if (this.cAccion == "Guardar" || this.url_refraccion == "") {
                let $inputArchivos = document.querySelector("#inputArchivos");
                $inputArchivos.value    = "";
            }
            this.fnHistoriaNumero();
            this.cAccion            = "Guardar";
            this.form.fecha         = "";
            this.form.hora          = "";
            this.form.descripcion   = "";
            this.id                 = "";
            this.url_refraccion     = "";
        }
    },
    mounted(){
        this.fnBuscar();
    }
}
</script>
<style scope>

</style>
