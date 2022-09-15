<template>
    <div>
        <loadingGeneral v-bind:overlayLoading="overlayLoading" />
        <v-btn
            color="primary"
            class="ma-2"
            dark
            @click="dialogParametro = true"
        >
            Crear Eps
        </v-btn>

        <!-- start Data table -->
        <v-row class="pt-0">
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
                    :pageCount="numberOfPages"
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
                    <template v-slot:item.acciones="{ item }">
                        <v-icon
                            color="primary"
                            @click="fnShow(item.id)"
                            title="Editar Registro"
                            v-if="$can(['VER', 'EDITAR'])"
                        >
                            mdi-pencil
                        </v-icon>
                    </template>
                </v-data-table>
            </v-col>
        </v-row>
        <!-- end Data table -->

        <v-row justify="center">
            <v-dialog v-model="dialogParametro" persistent max-width="600px">
                <v-card>
                    <v-card-title>
                        <span class="text-h5">{{ cAccionText }} EPS</span>
                    </v-card-title>
                    <v-card-text>
                        <v-container>
                            <v-row>
                                <v-col
                                    cols="12"
                                    sm="2"
                                    md="3"
                                    class="pt-0 pb-0"
                                >
                                    <v-text-field
                                        v-model="form.codigo"
                                        :error-messages="errors.codigo"
                                        label="Código*"
                                        hint="Código del registro"
                                        required
                                    ></v-text-field>
                                </v-col>
                                <v-col
                                    cols="12"
                                    sm="6"
                                    md="6"
                                    class="pt-0 pb-0"
                                >
                                    <v-text-field
                                        v-model="form.descripcion"
                                        :error-messages="errors.descripcion"
                                        label="Descripción*"
                                        hint="Descripción del registro"
                                        required
                                    ></v-text-field>
                                </v-col>
                                <v-col cols="12" sm="3" class="pt-0 pb-0">
                                    <v-select
                                        :items="items"
                                        v-model="form.estado"
                                        :error-messages="errors.estado"
                                        label="Estado*"
                                        title="Estado del Registro"
                                        required
                                    ></v-select>
                                </v-col>
                            </v-row>
                        </v-container>
                    </v-card-text>
                    <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn
                            dark
                            color="darken-1"
                            @click="dialogParametro = false"
                        >
                            Cerrar
                        </v-btn>
                        <v-btn
                            color="success"
                            class="white--text"
                            @click="fnAccion()"
                            :disabled="!$can(['CREAR', 'EDITAR'])"
                        >
                            {{ Accion }}
                        </v-btn>
                    </v-card-actions>
                </v-card>
            </v-dialog>
        </v-row>
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
            numberOfPages: 0,
            loading: false,
            overlayLoading : false,
            options: {},
            headers: [
                { text: "Código", value: "codigo" },
                { text: "Descripción", value: "descripcion", sortable: false },
                { text: "Estado", value: "estado", sortable: false },
                { text: "Fecha Creación", value: "created_at" },
                { text: "Fecha Modificado", value: "updated_at" },
                { text: "Acciones", value: "acciones", sortable: false }
            ],
            dataSet: [],

            dialogParametro: false,
            items: ["ACTIVO", "INACTIVO"],
            cAccionText: "CREAR",
            Accion: "GUARDAR",
            form: {
                parametrica: "p_eps",
                id   : "", // Id registro, este dato se almacena cuando se ingresa en la funcion fnShow
                codigo: "",
                descripcion: "",
                estado: "",
            },
            errors: {},
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
        fnAccion() {
            if (this.Accion === "GUARDAR") {
                this.fnStore();
            } else {
                this.fnUpdate();
            }
        },
        fnStore() {
            this.overlayLoading = true;
            axios
                .post(`/consultorio-oftamologico/parametro`, this.form)
                .then((response) => {
                    this.errors = "";
                    this.$swal(response.data.message, "", "success");
                    this.fnBuscar();
                    this.limpiarCampos();
                    this.overlayLoading = false;
                    this.dialogParametro = false;
                })
                .catch((errores) => {
                    this.errors = this.fnResponseError(errores);
                    this.overlayLoading = false;
                });
        },
        fnShow(id){
            this.overlayLoading = true;
            this.cAccionText = "EDITAR";
            this.Accion = "ACTUALIZAR";

            axios
                .get(`/consultorio-oftamologico/parametro/${this.form.parametrica}/${id}`)
                .then((response) => {
                    this.dialogParametro = true;
                    let data = response.data.data;

                    this.form.id          = data.id;
                    this.form.codigo      = data.codigo;
                    this.form.descripcion = data.descripcion;
                    this.form.estado      = data.estado;

                    this.errors = "";
                    this.overlayLoading = false;
                })
                .catch((errores) => {
                    this.errors = this.fnResponseError(errores);
                    this.overlayLoading = false;
                });
        },
        fnUpdate() {
            this.overlayLoading = true;

            axios
                .put(`/consultorio-oftamologico/parametro/${this.form.id}`, this.form)
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
                    this.dialogParametro = false;
                })
                .catch((errores) => {
                    this.errors = this.fnResponseError(errores);
                    this.overlayLoading = false;
                });
        },
        fnBuscar() {
            this.overlayLoading = true;
            this.loading = true;

            let { page, itemsPerPage, sortBy, sortDesc } = this.options;

            // Obteniendo rangos de consultado paginación.
            let start = itemsPerPage * (page - 1);
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
                    `/consultorio-oftamologico/parametro/buscar?length=${length}&start=${start}&orderColumn=${sortBy}&order=${sortDesc}&buscar=${this.buscar}&parametrica=${this.form.parametrica}`
                )
                .then((response) => {
                    this.loading = false;
                    this.totalRegistros = response.data.total;

                    this.dataSet = response.data.data;
                    this.overlayLoading = false;
                })
                .catch((errors) => {
                    this.overlayLoading = false;
                    this.loading = false;
                    this.dataSet = [];
                    this.fnResponseError(errors);
                });
        },
        limpiarCampos() {
            this.errors = {};
            this.form.codigo = "";
            this.form.descripcion = "";
            this.form.estado = "";
        },
    },
};
</script>
