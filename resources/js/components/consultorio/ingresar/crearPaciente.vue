<template>
    <div>
        <loadingGeneral v-bind:overlayLoading="overlayLoading" />
        <v-card elevation="2" class="pt-5">
            <v-row class="pl-4 pr-4">
                <v-col cols="12" sm="9">
                    <v-row>
                        <v-col cols="12" sm="4" class="pb-2">
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
                        <v-col cols="6" sm="4" class="pb-2">
                            <v-text-field
                                v-model="form.numero_documento"
                                label="Numero de Documento"
                                ref="numero_documento"
                                :error-messages="errors.numero_documento"
                                dense
                            ></v-text-field>
                        </v-col>
                        <v-col cols="6" sm="4" class="pb-2">
                            <v-text-field
                                v-model="form.nombre"
                                label="Nombre Completo"
                                ref="nombre"
                                :error-messages="errors.nombre"
                                dense
                            ></v-text-field>
                        </v-col>
                    </v-row>

                    <v-row>
                        <v-col cols="6" sm="4" class="pt-0 pb-2">
                            <v-text-field
                                type="date"
                                v-model="form.fecha_nacimiento"
                                ref="fecha_nacimiento"
                                label="Fecha de Nacimiento"
                                :error-messages="errors.fecha_nacimiento"
                                dense
                            ></v-text-field>
                        </v-col>
                        <v-col cols="6" sm="4" class="pt-0 pb-2">
                            <v-text-field
                                type="number"
                                v-model="form.edad"
                                label="Edad"
                                ref="edad"
                                :error-messages="errors.edad"
                                dense
                            ></v-text-field>
                        </v-col>
                        <v-col cols="12" sm="4" class="pt-0 pb-2">
                            <v-text-field
                                v-model="form.apellido"
                                label="Apellido Completo"
                                ref="apellido"
                                :error-messages="errors.apellido"
                                dense
                            ></v-text-field>
                        </v-col>
                    </v-row>

                    <v-row>
                        <v-col cols="12" sm="4" class="pt-0 pb-2">
                            <v-text-field
                                v-model="form.direccion"
                                label="Direccion u Ubicación"
                                ref="direccion"
                                :error-messages="errors.direccion"
                                dense
                            ></v-text-field>
                        </v-col>
                        <v-col cols="6" sm="4" class="pt-0 pb-2">
                            <v-autocomplete
                                v-model="form.departamento"
                                ref="departamento"
                                :items="departamentos"
                                item-value="text"
                                item-text="text"
                                :error-messages="errors.departamento"
                                label="Departamento"
                                dense
                                v-on:change="fnBuscarMunicipio(form.departamento)"
                            ></v-autocomplete>
                        </v-col>
                        <v-col cols="6" sm="4" class="pt-0 pb-2">
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
                    </v-row>

                    <v-row>
                        <v-col cols="6" sm="4" class="pt-0 pb-2">
                            <v-text-field
                                v-model="form.celular"
                                label="Celular"
                                ref="celular"
                                :error-messages="errors.celular"
                                dense
                            ></v-text-field>
                        </v-col>
                        <v-col cols="6" sm="4" class="pt-0 pb-2">
                            <v-text-field
                                v-model="form.ocupacion"
                                label="Ocupación"
                                ref="ocupacion"
                                :error-messages="errors.ocupacion"
                                dense
                            ></v-text-field>
                        </v-col>
                        <v-col cols="12" sm="4" class="pt-0 pb-2">
                            <v-text-field
                                type="email"
                                v-model="form.correo"
                                label="Correo"
                                ref="correo"
                                :error-messages="errors.correo"
                                dense
                            ></v-text-field>
                        </v-col>
                        <v-col cols="6" sm="4" class="pt-0 pb-2">
                            <v-radio-group v-model="radioGroupEps" row :error-messages="(radioGroupEps == '' || radioGroupEps == null) ? errors.id_p_eps : '' ">
                                <v-radio
                                    label="Particular"
                                    value="PARTICULAR"
                                ></v-radio>
                                <v-radio
                                    label="Prepagada"
                                    value="PREPAGADA"
                                ></v-radio>
                            </v-radio-group>
                        </v-col>
                        <v-col cols="6" sm="4" class="pt-0 pb-2">

                            <v-select
                                v-model="form.id_p_eps"
                                ref="id_p_eps"
                                label="EPS"
                                :items="itemsEpsPrepagada"
                                item-value="id"
                                item-text="descripcion"
                                :error-messages="errors.id_p_eps"
                                dense
                                v-if="radioGroupEps == 'PREPAGADA'"
                            ></v-select>
                        </v-col>
                        <v-col cols="4" sm="4"></v-col>
                    </v-row>
                </v-col>

                <v-col cols="12" sm="3" class="pt-7">
                    <v-card class="mx-auto" max-width="344">
                        <v-img
                            :src="(preview != null) ? preview : 'http://jago.co.nz/assets/camaleon_cms/image-not-found-4a963b95bf081c3ea02923dceaeb3f8085e1a654fc54840aac61a57a60903fef.png'"
                            height="200px" alt="Foto paciente">
                        </v-img>

                        <v-card-title>Foto</v-card-title>

                        <v-card-subtitle v-if="!preview">
                            <input type="file" name="foto" @change="previewImage" accept="image/*" style="width:100%;">

                        </v-card-subtitle>
                        <v-card-text v-if="preview">
                            <!-- <p class="mb-0" v-if="this.accion != 'Actualizar'">Nombre Archivo: {{ form.foto.name }}</p>
                            <p class="mb-0" v-if="this.accion != 'Actualizar'">Tamaño: {{ form.foto.size / 1024 }}KB</p> -->
                            <v-btn
                                type="click"
                                small
                                color="red darken-4"
                                class="white--text text-none mr-3"
                                tile
                                v-on:click="fnResetPhoto"
                            >
                                Remover
                            </v-btn>
                        </v-card-text>
                    </v-card>
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
import departamentos_municipios from "../../json/colombia.json";
import loadingGeneral from "../../loadingGeneral/loadingGeneral.vue";
import { commons } from "../../commons/commons.js";
export default {
    components: {
        loadingGeneral,
    },
    data() {
        return {
            accion              : 'Guardar',
            radioGroupEps       : '',
            itemsEpsPrepagada   : [],
            form: {
                id : "",
                tipo_documento: "",
                numero_documento: "",
                nombre: "",
                apellido: "",
                correo: "",
                celular: "",
                direccion: "",
                departamento: "",
                municipio: "",
                fecha_nacimiento: "",
                edad: "",
                ocupacion: "",
                foto: "",
                id_p_eps: "",
                fecha_creacion: new Date().toISOString().split("T")[0],
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
                { text: "Nombre", value: "nombre" },
                { text: "Identificación", value: "numero_documento" },
                { text: "Correo", value: "correo" },
                // { text: "Dirección", value: "direccion" },
                { text: "Celular", value: "celular" },
                { text: "Municipio", value: "municipio" },
                { text: "Fecha Modificado", value: "updated_at" },
                { text: "Acciones", value: "acciones", sortable: false },
            ],
            dataSet: [],
            /* end variables Table. */
            overlayLoading: false,

            /* previsualizar imagen */
            preview: null,
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

            //CONFIGURACION EPS
            if (this.radioGroupEps == "PARTICULAR") {
                this.form.id_p_eps = 1;
            }else{
                if (this.form.id_p_eps == 1) {
                    this.form.id_p_eps = "";
                }
            }

            let formData = new FormData();
            for (let key in this.form) {
                if (this.form[key] == null) {
                    this.form[key] = '';
                }
                formData.append(key, this.form[key]);
            }

            axios
                .post(`/consultorio-oftamologico/paciente`, formData, {
                    headers: {
                        'Content-Type': 'multipart/form-data',
                        'Accept' : 'application/json'
                    },
                })
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

            //CONFIGURACION EPS
            if (this.radioGroupEps == "PARTICULAR") {
                this.form.id_p_eps = 1;
            }else{
                if (this.form.id_p_eps == 1) {
                    this.form.id_p_eps = "";
                }
            }

            let formData = new FormData();
            for (let key in this.form) {
                if (this.form[key] == null) {
                    this.form[key] = '';
                }
                formData.append(key, this.form[key]);
            }

            axios
                .post(`/consultorio-oftamologico/paciente/actualizar/${this.form.id}`, formData,{
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
                    this.limpiarCampo();
                })
                .catch((errores) => {
                    if (errores.response.status == 409 || errores.response.status == 500 ) {
                        this.$swal({
                            icon: "error",
                            title: errores.response.data.message,
                            text : errores.response.data.errors[0]
                        });
                    }else{
                        this.errors = errores.response.data.errores;
                    }
                });
        },

        fnShow(id){

            this.overlayLoading = true;
            this.accion = "Actualizar";
            axios
                .get(`/consultorio-oftamologico/paciente/mostrar/${id}`)
                .then((response) => {
                    let data = response.data.data;

                    this.form = {
                        ... data
                    };

                    this.fnBuscarMunicipio(data.departamento);

                    this.form.municipio = this.fnRemoveAccents(data.municipio.toUpperCase());

                    if (data.id_p_eps == 1) {
                        this.radioGroupEps = "PARTICULAR";
                    } else{
                        this.radioGroupEps = "PREPAGADA";
                    }

                    if (data.foto != "") {
                        // Si la foto existe.
                        this.preview = "../../"+data.foto;
                    }else{
                        // Si no existe.
                        this.preview = null;
                    }

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
            this.start = itemsPerPage * (page - 1);
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
                    `/consultorio-oftamologico/paciente/listar?length=${this.length}&start=${this.start}&orderColumn=${sortBy}&order=${sortDesc}&buscar=${this.buscar}`
                )
                .then((response) => {
                    this.loading = false;
                    this.dataSet = response.data.data;
                    this.totalRegistros = response.data.total;
                    this.numberOfPages = response.data.totalPages;

                    // Limpiando mensajes de error del formulario.
                    const errors = {};
                    this.errors = errors;
                    this.overlayLoading = false;
                })
                .catch((errors) => {
                    this.overlayLoading = false;
                    this.loading = false;
                    this.dataSet = [];
                    this.$swal({
                        icon: "error",
                        title: `${errors.response.data.message}`,
                        text: `${errors.response.data.errors[0]}`,
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

        limpiarCampo() {
            this.overlayLoading = true;
            this.accion = "Guardar";

            this.form.tipo_documento = "";
            this.form.numero_documento = "";
            this.form.nombre = "";
            this.form.apellido = "";
            this.form.correo = "";
            this.form.celular = "";
            this.form.direccion = "";
            this.form.departamento = "";
            this.form.municipio = "";

            this.form.fecha_nacimiento = "";
            this.$refs["edad"].reset();
            this.form.ocupacion = "";
            this.fnResetPhoto();
            // this.$refs["id_p_eps"].reset();
            this.form.id_p_eps = "";
            this.errors = {};
            this.radioGroupEps = "";

            this.overlayLoading = false;
        },

        /* METODOS SUBIR IMAGEN */
        previewImage: function (event) {
            var input = event.target;
            if (input.files) {
                var reader = new FileReader();
                reader.onload = (e) => {
                    this.preview = e.target.result;
                };

                this.form.foto = input.files[0];
                reader.readAsDataURL(input.files[0]);
            }
        },
        fnResetPhoto(){
            this.form.foto      = '';
            this.preview   = null;
        },
    },
    async created() {
        /* Consultando campos parametros tipo lista. */
        this.itemsEpsPrepagada = await this.fnBuscarParametro('p_eps');

        let arrDepartamentos = [];
        for (let i = 0; i < departamentos_municipios.length; i++) {
            arrDepartamentos.push({
                value: departamentos_municipios[i].id,
                text: this.fnRemoveAccents(departamentos_municipios[i].departamento.toUpperCase()),
            });
        }
        this.departamentos = arrDepartamentos;
    },
    mounted() {},
};
</script>
