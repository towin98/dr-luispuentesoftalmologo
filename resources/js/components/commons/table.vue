<template>
    <div>
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
                        :disabled="!can(['LISTAR'])"
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
                    sort-by="id"
                    :sort-desc="true"
                    no-data-text="Sin registros"
                    :disable-sort="!can(['LISTAR'])"
                >
                    <template v-slot:item.editar="{ item }">
                        <v-icon
                            color="primary"
                            @click="fnShow(item.id)"
                            title="Editar Registro"
                            v-if="can(['VER', 'EDITAR'])"
                        >
                            mdi-pencil
                        </v-icon>
                    </template>
                    <template v-slot:item.eliminar="{ item }">
                        <v-icon
                            color="primary"
                            @click="fnShow(item.id)"
                            title="Eliminar Registro"
                            v-if="can(['ELIMINAR'])"
                        >
                            mdi-pencil
                        </v-icon>
                    </template>
                    <template v-slot:item.ver="{ item }">
                        <v-icon
                            color="primary"
                            @click="fnShow(item.id)"
                            title="Ver Registro"
                            v-if="can(['VER'])"
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
export default {
    props: ["headers", "permisos", "url_buscar"],
    data() {
        return {
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
            dataSet: [],
            /* end variables Table. */
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
    methods : {
        /**
         * Método que verifica si el usuario tiene al menos un permiso pasado como parametro.
         *
         * @param {Array} permissionName Array de permisos.
         * @returns {Boolean} true si tiene permiso o false de lo contrario.
         */
        can(permissionName = []) {
            let permissionsEncontrado = false;
            permissionName.forEach(permiso => {
                if (this.permisos.indexOf(permiso) !== -1) {
                    permissionsEncontrado = true;
                }
            });
            return permissionsEncontrado;
        },
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
                    `${this.url_buscar}?length=${length}&start=${start}&orderColumn=${sortBy}&order=${sortDesc}&buscar=${this.buscar}`
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
        fnShow(){

        }

    },

}
</script>
