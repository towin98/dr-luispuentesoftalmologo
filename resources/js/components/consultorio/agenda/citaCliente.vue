<template>
    <div>
        <loadingGeneral v-bind:overlayLoading="overlayLoading" />
        <!-- FORMULARIO -->
        <v-card elevation="2" class="mt-7">
            <h3 class="text-center pt-2 pb-2">Cita Paciente</h3>

            <v-row class="ml-2 mr-2">
                <v-col cols="12" sm="5" class="pb-0">
                    <v-autocomplete
                        v-model="autocomplete_numero_documento"
                        :items="pacienteData"
                        :loading="isLoading"
                        :search-input.sync="search_paciente"
                        hide-no-data
                        item-text="description"
                        item-value="id"
                        label="Buscar Paciente"
                        placeholder="Ingrese numero documento, nombre o apellido."
                        :error-messages="errors.numero_documento"
                        @change="fnCargarInfoPaciente"
                        :readonly="numero_documento_readonly"
                        :disabled="disabledCampos"
                    ></v-autocomplete>
                </v-col>
            </v-row>
            <v-row class="ml-2 mr-2">
                <v-col cols="12" sm="3" class="pb-0">
                    <v-select
                        v-model="tipo_documento"
                        ref="tipo_documento"
                        label="Tipo de Documento"
                        :items="tiposDocumentosItems"
                        item-value="value"
                        item-text="text"
                        :error-messages="errors.tipo_documento"
                        dense
                        disabled
                    ></v-select>
                </v-col>
                <v-col cols="12" sm="3" class="pb-0">
                    <v-text-field
                        v-model="numero_documento"
                        label="Número de Documento"
                        dense
                        disabled
                    ></v-text-field>
                </v-col>
                <v-col cols="6" sm="3" class="pb-0">
                    <v-text-field
                        v-model="nombre"
                        label="Nombre"
                        dense
                        disabled
                    ></v-text-field>
                </v-col>
                <v-col cols="6" sm="3" class="pb-0">
                    <v-text-field
                        v-model="apellido"
                        label="Apellido"
                        dense
                        disabled
                    ></v-text-field>
                </v-col>
                <v-col cols="6" sm="4" class="pt-3 pb-0">
                    <v-text-field
                        v-model="celular"
                        label="Celular"
                        ref="celular"
                        dense
                        disabled
                    ></v-text-field>
                </v-col>
                <v-col cols="6" sm="4" class="pt-0 pb-0">
                    <v-radio-group v-model="radioGroupEps" row>
                        <v-radio
                            label="Particular"
                            value="PARTICULAR"
                            disabled
                        ></v-radio>
                        <v-radio
                            label="Prepagada"
                            value="PREPAGADA"
                            disabled
                        ></v-radio>
                    </v-radio-group>
                </v-col>
                <v-col cols="6" sm="4" class="pt-3 pb-0">
                    <v-select
                        v-model="id_p_eps"
                        ref="id_p_eps"
                        label="MP"
                        :items="itemsEpsPrepagada"
                        item-value="id"
                        item-text="descripcion"
                        dense
                        v-if="radioGroupEps == 'PREPAGADA'"
                        disabled
                    ></v-select>
                </v-col>
            </v-row>

            <v-row class="ml-2 mr-2">
                <v-col cols="6" sm="4" class="pb-0">
                    <v-select
                        v-model="form.tipo_consulta"
                        ref="tipo_consulta"
                        label="Tipo de Consulta"
                        :items="tiposConsultaCitaItems"
                        item-value="value"
                        item-text="text"
                        :error-messages="errors.tipo_consulta"
                        dense
                        title="Tipo consulta de Cita, seleccione"
                        :disabled="disabledCampos"
                    ></v-select>
                </v-col>
                <v-col cols="6" sm="4" class="pb-0">
                    <v-text-field
                        type="date"
                        v-model="form.fecha_cita"
                        ref="fecha_cita"
                        label="Fecha Cita"
                        :error-messages="errors.fecha_cita"
                        dense
                        :disabled="disabledCampos"
                        @change="fnHorasCita()"
                    ></v-text-field>
                </v-col>
                <v-col cols="6" sm="4" class="pb-0">
                    <v-select
                        v-model="form.hora_cita"
                        ref="hora_cita"
                        label="Hora Cita"
                        :items="horasCitaItems"
                        :error-messages="errors.hora_cita"
                        dense
                        title="Seleccione hora de la cita."
                        :disabled="disabledCampos"
                        no-data-text="Sin horas citas, seleccione una fecha cita o cambie fecha de citas para buscar"
                    ></v-select>
                </v-col>
                <v-col cols="12" sm="12" class="pt-0 pb-0">
                    <v-subheader>Observaciones</v-subheader>
                    <v-textarea
                        v-model="form.observacion"
                        ref="observacion"
                        placeholder="Agreue aquí alguna observación para la cita del paciente."
                        outlined
                        dense
                        :error-messages="errors.observacion"
                        rows="2"
                        :disabled="disabledCampos"
                        >
                    </v-textarea>
                </v-col>

                <!-- BOTONES ACCIONES  -->
                <v-col cols="12" class="d-flex justify-end">
                    <v-btn
                        type="button"
                        small
                        color="grey"
                        class="mr-3 text-none"
                        icon
                        v-on:click="fnBuscar"
                        title="Recargar Registros"
                    >
                        <v-icon> refresh </v-icon>
                    </v-btn>
                    <v-btn
                        type="submit"
                        small
                        color="red darken-4"
                        class="white--text text-none mr-3"
                        tile
                        v-on:click="fnLimpiar();fnLimpiarInfoPaciente('SI');"
                    >
                        <v-icon> format_clear </v-icon>Limpiar Todo
                    </v-btn>
                    <v-btn
                        type="submit"
                        small
                        color="success"
                        class="white--text text-none"
                        tile
                        v-on:click="fnAccion"
                        v-if="accion == 'Editar_Cita'"
                    >
                        <v-icon> save </v-icon>Editar Cita
                    </v-btn>

                    <v-btn
                        type="submit"
                        small
                        color="success"
                        class="white--text text-none"
                        tile
                        v-on:click="fnAccion"
                        v-if="accion == 'Agendar_Cita'"
                    >
                        <v-icon> save </v-icon>Agendar Cita
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
                    <template v-slot:item.ver="{ item }">
                        <v-icon
                            color="primary"
                            class="mr-2"
                            @click="fnShow(item.id, 'VER')"
                            title="Ver Cita"
                        >
                            visibility
                        </v-icon>
                    </template>
                    <template v-slot:item.editar="{ item }">
                        <v-icon
                            color="primary"
                            class="mr-2"
                            @click="fnShow(item.id, 'EDITAR')"
                            title="Editar Cita"
                        >
                            edit
                        </v-icon>
                    </template>
                    <template v-slot:item.eliminar="{ item }">
                        <v-icon
                            color="red"
                            class="mr-2"
                            @click="fnDelete(item)"
                            title="Eliminar Cita"
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
import tiposDocumentos from "../../json/tiposDocumentos.json";
import tiposConsulta from "../../json/tiposConsulta.json";
export default {
    components: {
        loadingGeneral,
    },
    data() {
        return {
            accion          : 'Agendar_Cita',
            disabledCampos  : false,
            // Formulario
            errors          :"",
            form: {
                numero_documento              : '',
                tipo_consulta                 : '',
                fecha_cita                    : '',
                hora_cita                     : '',
                observacion                   : ''
            },
            radioGroupEps       : '',
            search_paciente: null,
            pacienteData: [],
            debounce : null,
            numero_documento_readonly : false,

            // Variables autocomplete
            isLoading: false, // loading de autocomplete
            autocomplete_numero_documento : null,

            // Variables para informacion de paciente solo MOSTRAR.
            id_cita              : '',
            tipo_documento       : '',
            numero_documento     : '',
            nombre               : '',
            apellido             : '',
            celular              : '',
            id_p_eps             : '',

            tiposDocumentosItems    : [],
            itemsEpsPrepagada       : [],
            tiposConsultaCitaItems  : [],
            horasCitaItems          : [],

            overlayLoading: false,

            // Variables table.
            buscar: "",
            page: 1,
            totalRegistros: 0,
            numberOfPages: 0,
            loading: false,
            options: {},
            headers: [
                { text: "Identificación", value: "numero_documento" },
                { text: "Paciente", value: "nombre_apellido" },
                { text: "EPS", value: "eps" },
                { text: "Tipo Consulta", value: "tipo_consulta" },
                // { text: "Celular", value: "celular" },
                { text: "Fecha Cita", value: "fecha_cita" },
                { text: "Hora", value: "hora_cita" },
                { text: "Fecha Modificado", value: "updated_at" },
                { text: "Ver", value: "ver", sortable: false },
                { text: "Editar", value: "editar", sortable: false },
                { text: "Eliminar", value: "eliminar", sortable: false },
            ],
            dataSet: [],
            /* end variables Table. */
        };
    },

    watch: {
        search_paciente(val) {
            this.fnAutoCompletePaciente(val);
        },
        options: {
            handler() {
                this.fnBuscar();
            },
        },
    },
    methods: {
        fnAutoCompletePaciente(val, timeout = 'SI'){
            if (val == "" || val == null) {
                this.fnLimpiarInfoPaciente();
                // this.overlayLoading = false;
                return;
            }

            if (this.autocomplete_numero_documento != null && this.autocomplete_numero_documento != '') {
                let vNumeroDocumento = val.split('-');
                // No se permite buscar al seleccionar registro en el autocomplete.
                if (this.autocomplete_numero_documento === vNumeroDocumento[0]) {
                    // this.overlayLoading = false;
                    return;
                }
            }

            // Los artículos ya han sido solicitados
            if (this.isLoading) return;

            // Borra el retraso asignado
            clearTimeout(this.debounce);
            this.debounce = setTimeout(() => {
                this.overlayLoading = true;
                this.isLoading = true;
                axios
                    .post(`/consultorio-oftamologico/agenda/cita-cliente/busqueda-paciente-autocomplete`, {valor: val })
                    .then((response) => {
                        this.pacienteData = response.data.data;
                        this.errors = "";

                        if (this.pacienteData.length == 0) {
                            this.autocomplete_numero_documento = null;
                        }

                        // Si devuelve solo un dato se carga automaticamente el paciente.
                        this.overlayLoading = false;

                        if (this.pacienteData.length == 1) {
                            this.autocomplete_numero_documento = this.pacienteData[0].id;
                            this.fnCargarInfoPaciente();
                        }
                    })
                    .catch((errores) => {
                        this.errors = this.fnResponseError(errores);
                        this.autocomplete_numero_documento = null;
                        this.overlayLoading = false;
                    })
                    .finally(() => (this.isLoading = false));
            }, (timeout == 'SI' ? 800 : 0) );
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
            this.start  = itemsPerPage * (page - 1);
            this.length = itemsPerPage;

            if (sortDesc[0] == true) {
                sortBy   = sortBy[0];
                sortDesc = "DESC";
            } else if (sortDesc[0] == false) {
                sortBy   = sortBy[0];
                sortDesc = "ASC";
            } else {
                sortBy   = "";
                sortDesc = "";
            }

            axios
                .get(
                    `/consultorio-oftamologico/agenda/cita-cliente/listar?length=${this.length}&start=${this.start}&orderColumn=${sortBy}&order=${sortDesc}&buscar=${this.buscar}`
                )
                .then((response) => {
                    let data         = response.data.data;
                    for (let i = 0; i < data.length; i++) {
                        data[i].paciente = data[i].nombre + " "+  data[i].apellido;

                    }
                    this.dataSet        = response.data.data;
                    this.totalRegistros = response.data.total;
                    this.numberOfPages  = response.data.totalPages;

                    // Limpiando mensajes de error del formulario.
                    this.errors = {};
                    this.loading        = false;
                    this.overlayLoading = false;
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
        fnAccion(){
            if (this.accion === "Agendar_Cita") {
                this.fnstoreCitaPaciente();
            }else{
                this.fnUpdate();
            }
        },
        fnCargarInfoPaciente(){
            this.overlayLoading = true;
            if (this.autocomplete_numero_documento == null || this.autocomplete_numero_documento == "") {
                this.fnLimpiarInfoPaciente();
                this.overlayLoading = false;
                // El numero de documento del autocomplete esta vacio o null no se permite buscar info del paciente.
                return;
            }
            this.numero_documento_readonly = true;
            axios
                .get(`/consultorio-oftamologico/agenda/cita-cliente/cargar-informacion-paciente?numero_documento=${this.autocomplete_numero_documento}`)
                .then((response) => {
                    const data = response.data.data;
                    this.tipo_documento   = data.tipo_documento;
                    this.numero_documento = data.numero_documento;
                    this.nombre           = data.nombre;
                    this.apellido         = data.apellido;
                    this.id_p_eps         = data.id_p_eps;
                    this.celular          = data.celular;

                    if (data.id_p_eps == 1) {
                        this.radioGroupEps = "PARTICULAR";
                    } else{
                        this.radioGroupEps = "PREPAGADA";
                    }

                    this.overlayLoading = false;
                    this.numero_documento_readonly = false;
                })
                .catch((errores) => {
                    this.errors = this.fnResponseError(errores);
                    this.overlayLoading = false;
                    this.numero_documento_readonly = false;
                })
                .finally(() => (this.isLoading = false));
        },
        fnstoreCitaPaciente(){
            this.overlayLoading = true;
            if (this.autocomplete_numero_documento !=  null && this.autocomplete_numero_documento != "") {
                this.form.numero_documento = this.autocomplete_numero_documento;
            }// ?

            axios
                .post(`/consultorio-oftamologico/agenda/cita-cliente/guardar`, this.form)
                .then((response) => {
                    this.$swal(
                        response.data.message,
                        '',
                        'success'
                    );
                    this.errors = {};
                    this.fnLimpiar();
                    this.fnLimpiarInfoPaciente('SI');
                    this.fnBuscar();
                    this.overlayLoading = false;
                })
                .catch((errores) => {
                    this.overlayLoading = false;
                    this.errors = this.fnResponseError(errores);
                })
                .finally(() => (this.isLoading = false));
        },
        /* METODOS QUE LIMPIAN CAMPOS - START*/
        fnLimpiar() {
            this.overlayLoading = true;
            this.accion = "Agendar_Cita";
            this.form.tipo_consulta     = "";
            this.form.fecha_cita        = "";
            this.form.hora_cita         = "";
            this.horasCitaItems         = [];
            this.form.observacion       = "";
            this.errors                 = {};
            this.overlayLoading         = false;
            this.disabledCampos         = false;
        },
        fnLimpiarInfoPaciente(clear_autocomplete = 'NO'){
            if(clear_autocomplete == 'SI') {
                this.autocomplete_numero_documento  = "";
                this.pacienteData                   = [];
            }
            this.tipo_documento                      = "";
            this.numero_documento                    = "";
            this.nombre                              = "";
            this.apellido                            = "";
            this.radioGroupEps                       = "";
            this.celular                             = "";
        },
        /* METODOS QUE LIMPIAN CAMPOS - END*/

        fnShow(id, mostrar){
            this.disabledCampos = (mostrar == 'VER' ? true : false);
            this.id_cita = id;
            this.overlayLoading = true;
            this.accion = "Editar_Cita";
            axios
                .get(`/consultorio-oftamologico/agenda/cita-cliente/mostrar/${id}`)
                .then((response) => {
                    const data = response.data.data;
                    // Solo se busca info en el autocomplete de paciente si se selecciona un paciente diferente.
                    if (data.get_paciente.numero_documento != this.autocomplete_numero_documento) {
                        // this.autocomplete_numero_documento = null;
                        this.fnAutoCompletePaciente(data.get_paciente.numero_documento, 'NO');
                    }else{
                        this.overlayLoading = false;
                    }
                    this.form.tipo_consulta = data.tipo_consulta;
                    this.form.fecha_cita    = data.fecha_cita;
                    this.form.hora_cita     = data.hora_cita.substr(0,5);
                    this.form.observacion   = data.observacion;
                    this.fnHorasCita(data.hora_cita);

                    this.errors = "";
                })
                .catch((errores) => {
                    this.$swal({
                        icon: 'error',
                        title: `Error al mostrar la información.`,
                        text: `Por favor comunicate con el área de Tecnología.`,
                    })
                    this.overlayLoading = false;
                });
        },
        fnUpdate(){
            this.overlayLoading = true;
            this.form.numero_documento = this.autocomplete_numero_documento;
            this.form.hora_cita        = this.form.hora_cita.substr(0,5); // Recortando Hora, formato aceptado H:i
            axios
                .put(`/consultorio-oftamologico/agenda/cita-cliente/actualizar/${this.id_cita}`, this.form)
                .then((response) => {
                    this.errors = "";
                    this.$swal(
                        response.data.message,
                        '',
                        'success'
                    );
                    this.fnBuscar();
                    this.fnLimpiar();
                    this.fnLimpiarInfoPaciente('SI');
                    this.overlayLoading = false;
                })
                .catch((errores) => {
                    this.errors = this.fnResponseError(errores);
                    this.overlayLoading = false;
                });
        },
        fnDelete(item){
            this.$swal({
            title: '¿Seguro que quiere Eliminar Cita?',
            text: `Eliminar Cita del Paciente ${item.nombre_apellido}!`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si, Eliminar!'
            }).then((result) => {
                if (result.isConfirmed) {

                    this.overlayLoading = true;

                    axios.post(`/consultorio-oftamologico/agenda/cita-cliente/delete/${item.id}`)
                    .then((response) => {
                        this.errors = "";
                        this.$swal(
                            '',
                            response.data.message,
                            'success'
                        );
                        this.fnBuscar();
                        this.fnLimpiar();
                        this.fnLimpiarInfoPaciente('SI');
                        this.overlayLoading = false;
                    })
                    .catch((errores) => {
                        this.fnResponseError(errores);
                        this.overlayLoading = false;
                    });

                }
            });
        },
        fnHorasCita(show_hora = ""){
            this.horasCitaItems = [];

            let isValidDate = Date.parse(this.form.fecha_cita);
            if (isNaN(isValidDate)) {
                // Formato Invalido
            }else{
                // Formato Valido
                const data = {
                    hora_inicio : "08:00:00",
                    hora_fin    : "17:00:00",
                    intervalo   : 20,
                    fecha_cita  : this.form.fecha_cita,
                    show_hora   : show_hora
                };

                // Si show_hora es diferente a vacio viene de fnShow().
                if (show_hora == "") {
                    this.form.hora_cita = "";
                    this.overlayLoading = true;
                }

                axios
                    .post(
                        `/consultorio-oftamologico/agenda/cita-cliente/horas-disponible-citas`, data
                    )
                    .then((response) => {
                        this.horasCitaItems = response.data;
                        // Si show_hora es diferente a vacio viene de fnShow().
                        if (show_hora == "") {
                            this.overlayLoading = false;
                        }
                    })
                    .catch((errores) => {
                        this.horasCitaItems = [];
                        this.fnResponseError(errores);
                        this.overlayLoading = false;
                    });
            }
        }
    },

    async created(){
        this.tiposDocumentosItems   = tiposDocumentos;
        this.tiposConsultaCitaItems = tiposConsulta;
        this.itemsEpsPrepagada      = await this.fnBuscarParametro('p_eps');
    }
};
</script>
