<template>
    <div>
        <loadingGeneral v-bind:overlayLoading="overlayLoading" />
        <h4>Auditoría del sistema</h4>

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
                    :calculate-widths="true"
                    :pageCount="numberOfPages"
                    :items="dataSet"
                    :options.sync="options"
                    :server-items-length="totalRegistros"
                    :loading="loading"
                    class="elevation-1"
                    :items-per-page="5"
                    :footer-props="{
                        'items-per-page-options': [15, 30, 60],
                    }"
                    sort-by="created_at"
                    :sort-desc="true"
                    no-data-text="Sin registros"
                    :disable-sort="!$can(['LISTAR'])"
                    style="line-height: normal;"
                >
                    <template v-slot:item.old_values="{ item }">
                        <a href="#" @click="fnShow(item)"
                            title="Ver en detalle acción"
                            v-if="item.old_values.length > 100 ">Ver
                        </a>
                        <pre style="white-space: pre-line;line-height: normal;" v-else>
                            {{ JSON.parse(item.old_values) }}
                        </pre>

                    </template>
                    <template v-slot:item.new_values="{ item }">
                        <a href="#" @click="fnShow(item)"
                            title="Ver en detalle acción"
                            v-if="item.new_values.length > 100 ">Ver
                        </a>
                        <pre style="white-space: pre-line;line-height: normal;" v-else>
                            {{ JSON.parse(item.new_values) }}
                        </pre>
                    </template>
                    <template v-slot:item.accion="{ item }">
                        <v-icon
                            color="primary"
                            @click="fnShow(item)"
                            title="Ver en detalle acción"
                            small
                            v-if="$can(['VER'])"
                        >
                            travel_explore
                        </v-icon>
                    </template>
                </v-data-table>
            </v-col>
        </v-row>
        <!-- end Data table -->

        <!-- Start Modal -->
        <v-dialog v-model="modalDetalleAudits" persistent max-width="600px">
            <v-card>
                <v-toolbar color="grey lighten-2" >Detalle de la acción - {{ evento }}</v-toolbar>
                <v-card-text class="mt-3">
                    <div>
                        <b>Realizada por: </b> {{ email }} <br>
                        <b>Mediente Url: </b> {{ url }} <br>
                        <b>Desde : </b> {{ user_agent }}
                    </div>
                    <h5>Valores Antiguos</h5>
                    <pre style="white-space: pre-line;line-height: normal;">
                        {{ old_values }}
                    </pre>
                    <h5>Nuevos Valores</h5>
                    <pre style="white-space: pre-line;line-height: normal;">
                        {{ new_values }}
                    </pre>
                </v-card-text>
                <v-divider></v-divider>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn dark small @click="modalDetalleAudits = false">Cancelar</v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
        <!-- end Modal -->
    </div>
</template>
<script>
import loadingGeneral from "../loadingGeneral/loadingGeneral.vue";
export default {
    components: {
        loadingGeneral,
    },
    watch: {
        options: {
            handler() {
                this.fnBuscar();
            },
        },
        deep: true,
    },
    data() {
        return {
            overlayLoading: false,

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
                { text: "Usuario", value: "name" },
                // { text: "Email", value: "email" },
                { text: "Módulo", value: "tags" },
                { text: "Evento", value: "event" },
                { text: "Auditable_id", value: "auditable_id" },
                { text: "Valores Antiguos", value: "old_values", sortable: false },
                { text: "Nuevos Valores", value: "new_values", sortable: false },
                // { text: "Url", value: "url", sortable: false},
                // { text: "user_agent", value: "user_agent", sortable: false },
                { text: "Fecha Acción", value: "created_at" },
                { text: "Acción", value: "accion", sortable: false }
            ],
            dataSet: [],

            modalDetalleAudits : false,
            old_values: '',
            new_values: '',
            evento: '',
            email: '',
            url: '',
            user_agent: ''
        };
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
                    `/consultorio-oftalmologico/config/auditing-buscar?length=${length}&start=${start}&orderColumn=${sortBy}&order=${sortDesc}&buscar=${this.buscar}`
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
                    console.log(errors.response);
                    // this.fnResponseError(errors);
                });
        },
        fnShow(item){
            this.old_values = JSON.parse(item.old_values);
            this.new_values = JSON.parse(item.new_values);
            this.evento     = item.event;
            this.email      = item.email;
            this.url        = item.url;
            this.user_agent = item.user_agent;
            this.modalDetalleAudits =  true;
        }
    },
};
</script>
