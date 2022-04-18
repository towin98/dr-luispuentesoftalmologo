<template>
    <div>
        <loadingGeneral v-bind:overlayLoading="overlayLoading"/>
        <v-row class="">
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

        <v-row class="">
            <v-col cols="6" sm="3" class="pt-0 pb-2">
                <v-text-field
                    v-model="form.razon_social"
                    label="Razón Social"
                    ref="razon_social"
                    :error-messages="errors.razon_social"
                    dense
                ></v-text-field>
            </v-col>
            <v-col cols="6" sm="3" class="pt-0 pb-2">
                <v-text-field
                    v-model="form.nit"
                    label="Nit"
                    ref="nit"
                    :error-messages="errors.nit"
                    dense
                ></v-text-field>
            </v-col>
            <v-col cols="6" sm="3" class="pt-0 pb-2">
                <v-text-field
                    type="email"
                    v-model="form.correo"
                    label="Correo"
                    ref="correo"
                    :error-messages="errors.correo"
                    dense
                ></v-text-field>
            </v-col>
            <v-col cols="6" sm="3" class="pt-0 pb-2">
                <v-text-field
                    type="number"
                    v-model="form.celular"
                    label="Celular"
                    ref="celular"
                    :error-messages="errors.celular"
                    dense
                ></v-text-field>
            </v-col>
        </v-row>

        <v-row class="">
            <v-col cols="6" sm="3" class="pt-0 pb-2">
                <v-text-field
                    v-model="form.direccion"
                    label="Direccion u Ubicación"
                    ref="direccion"
                    :error-messages="errors.direccion"
                    dense
                ></v-text-field>
            </v-col>
            <v-col cols="6" sm="3" class="pt-0 pb-2">
                <v-autocomplete
                    v-model="form.departamento"
                    :items="departamentos"
                    item-value="text"
                    item-text="text"
                    ref="departamento"
                    :error-messages="errors.departamento"
                    label="Departamento"
                    dense
                    v-on:change="fnBuscarMunicipio(form.departamento)"
                ></v-autocomplete>
            </v-col>
            <v-col cols="6" sm="3" class="pt-0 pb-2">
                <v-autocomplete
                    v-model="form.municipio"
                    ref="municipio"
                    :items="municipios"
                    item-value="value"
                    item-text="text"
                    :error-messages="errors.municipio"
                    label="Municipio"
                    dense
                ></v-autocomplete>
            </v-col>
            <v-col cols="6" sm="3" class="pt-0 pb-2">
                <v-text-field
                    v-model="form.fecha_creacion"
                    ref="fecha_creacion"
                    label="Fecha de creacion"
                    :error-messages="errors.fecha_creacion"
                    readonly
                    dense
                ></v-text-field>
            </v-col>

            <!-- BOTONES ACCIONES  -->
            <v-col cols="12" class="d-flex justify-end">
                <v-btn
                    type="submit"
                    small
                    color="red darken-4"
                    class="white--text text-none mr-3"
                    tile
                    v-on:click="limpiarCampo"
                >
                    <v-icon> format_clear </v-icon>Limpiar
                </v-btn>
                <v-btn
                    type="submit"
                    small
                    color="success"
                    class="white--text text-none"
                    tile
                    v-on:click="fnAccion"
                >
                    <v-icon> save </v-icon>{{ accion }}
                </v-btn>
            </v-col>
        </v-row>

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
                    :pageCount="numberOfPages"
                    :headers="headers"
                    :items="dataSet"
                    :options.sync="options"
                    :server-items-length="totalRegistros"
                    :loading="loading"
                    class="elevation-1"
                    :items-per-page="5"
                    item-key="nit"
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
                            title="Editar Persona Juridica."
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
import departamentos_municipios from "../../json/colombia.json";
import loadingGeneral from "../../loadingGeneral/loadingGeneral.vue";
import { commons } from "../../commons/commons.js";
export default {
    components : {
        loadingGeneral
    },
    data() {
        return {
            accion : 'Guardar',
            form: {
                id : "",
                tipo_cliente : "persona_juridica",
                tipo_documento: "",
                numero_documento : "",
                nombre: "",
                apellido: "",
                razon_social: "",
                nit: "",
                correo: "",
                celular: "",
                direccion: "",
                departamento: "",
                municipio: "",
                fecha_creacion: new Date().toISOString().split('T')[0],
            },
            tiposDocumentos: [
                { value: "CC", text: "CEDULA DE CIUDADANIA" },
                { value: "CE", text: "CEDULA DE EXTRANJERIA" },
                { value: "NIP", text: "NUMERO DE IDENTIFICACION PERSONAL" },
                { value: "NIT", text: "NUMERO DE IDENTIFICACION TRIBUTARIA" },
                { value: "TI", text: "TARJETA DE IDENTIDAD" },
                { value: "PAP", text: "PASAPORTE" },
            ],
            departamentos: [],
            municipios: [],
            errors: {},

            /* Variables Table. */
            // Tabla filtro.
            debounce: null,
            buscar: "",
            // Table listar
            page: 1,
            totalRegistros: 0,
            numberOfPages: 0,
            loading: false,
            options: {},
            headers: [
                { text: "Nit", align: "start", value: "nit" },
                { text: "Nombre", value: "nombre" },
                { text: "Razón", value: "razon_social" },
                { text: "Identificación", value: "numero_documento" },
                { text: "Correo", value: "correo" },
                { text: "Dirección", value: "direccion" },
                // { text: "Celular", value: "celular" },
                { text: "Municipio", value: "municipio" },
                { text: "Fecha Modificado", value: "updated_at" },
                { text: "Acciones", value: "acciones", sortable: false },
            ],
            dataSet: [],
            /* end variables Table. */
            overlayLoading      : false,
        };
    },
    watch: {
        options: {
            handler() {
                this.fnBuscar();
            },
        },
        deep: true,
    },
    mixins: [commons],
    methods: {
        fnAccion(){
            if (this.accion === "Guardar") {
                this.fnStore();
            }else{
                this.fnUpdate();
            }
        },

        fnStore() {
            for (let key in this.form) {
                if (this.form[key] == null) {
                    this.form[key] = '';
                }
            }
            axios
                .post(`/consultorio-oftamologico/cliente`, this.form)
                .then((response) => {
                    this.$swal(
                        response.data.message,
                        '',
                        'success'
                    );
                    this.fnBuscar();
                    this.limpiarCampo();
                    this.errors = '';
                })
                .catch((errores) => {
                    if (errores.response.status == 409 || errores.response.status == 500 ) {
                        this.$swal({
                            icon: "error",
                            title: errores.response.data.message,
                            text : errores.response.data.errores[0]
                        });
                    }else{
                        this.errors = errores.response.data.errores;
                    }
                });
        },

        fnUpdate(){
            for (let key in this.form) {
                if (this.form[key] == null) {
                    this.form[key] = '';
                }
            }
            axios
                .post(`/consultorio-oftamologico/cliente/actualizar/${this.form.id}`, this.form)
                .then((response) => {
                    this.errors = "";
                    this.$swal(
                        response.data.message,
                        '',
                        'success'
                    );
                    this.fnBuscar();
                    this.limpiarCampo();
                })
                .catch((errores) => {
                    console.log(errores.response.data);
                    this.errors = errores.response.data.errores;
                });
        },

        fnShow(id){

            this.overlayLoading = true;
            this.accion = "Actualizar";
            axios
                .get(`/consultorio-oftamologico/cliente/mostrar/${id}`)
                .then((response) => {
                    let data = response.data.data;

                    this.form = {
                        ... data
                    };

                    this.fnBuscarMunicipio(data.departamento);

                    this.form.municipio = this.fnRemoveAccents(data.municipio.toUpperCase());

                    this.errors = "";
                    this.overlayLoading = false;
                })
                .catch((errores) => {
                    this.$swal({
                        icon: 'error',
                        title: `Error al mostrar la información.`,
                        text: `Por favor comunicate con el área de Desarrollo Sajona.`,
                    })
                    this.overlayLoading = false;
                });
        },

        fnBuscarMunicipio(text_departamento) {

            this.form.municipio = "";
            if (text_departamento != null) {
                let municipiosData = departamentos_municipios.find(
                    (departamento) => this.fnRemoveAccents(departamento.departamento.toUpperCase()) == text_departamento.toUpperCase()
                );

                let arrMunicipios = [];
                for (let i = 0; i < municipiosData.ciudades.length; i++) {
                    arrMunicipios.push({
                        value: this.fnRemoveAccents(municipiosData.ciudades[i].toUpperCase()),
                        text: this.fnRemoveAccents(municipiosData.ciudades[i].toUpperCase()),
                    });
                }

                this.municipios = arrMunicipios;
            }else{
                this.municipios = [];
                this.form.municipio = "";
                this.form.departamento = "";
            }

        },
        fnBuscar() {
            this.overlayLoading = true;
            this.loading = true;
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
                    `/consultorio-oftamologico/cliente/listar/persona-juridica?length=${this.length}&start=${this.start}&orderColumn=${sortBy}&order=${sortDesc}&buscar=${this.buscar}`
                )
                .then((response) => {
                    this.loading = false;
                    this.dataSet = response.data.data;
                    this.totalRegistros = response.data.total;
                    this.numberOfPages = response.data.totalPages;

                    // Limpiando mensajes de error del formulario.
                    const errors = {
                    };
                    this.errors = errors;
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

        limpiarCampo() {
            this.overlayLoading = true;
            this.accion = "Guardar";
            this.errors = "";

            this.$refs["tipo_documento"].reset();
            this.$refs["numero_documento"].reset();
            this.$refs["nombre"].reset();
            this.$refs["apellido"].reset();
            this.$refs["razon_social"].reset();
            this.$refs["nit"].reset();
            this.$refs["correo"].reset();
            this.$refs["celular"].reset();
            this.$refs["direccion"].reset();
            this.$refs["departamento"].reset();
            this.$refs["municipio"].reset();

            this.overlayLoading = false;
        }
    },
    created() {
        let arrDepartamentos = [];
        for (let i = 0; i < departamentos_municipios.length; i++) {
            arrDepartamentos.push({
                value: departamentos_municipios[i].id,
                text: this.fnRemoveAccents(departamentos_municipios[i].departamento.toUpperCase()),
            });
        }
        this.departamentos = arrDepartamentos;
    },
    mounted() {
    },
};
</script>
