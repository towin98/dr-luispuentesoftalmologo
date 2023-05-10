<template>
    <div>
        <div class="d-flex justify-end">
            <!-- Evolución  -->
            <v-btn
                type="button"
                small
                color="grey"
                class="white--text text-none"
                tile
                v-on:click="fnRegresarHistoriaClinica()"
            >
                Regresar
                <v-icon right> keyboard_return </v-icon>
            </v-btn>
        </div>

        <loadingGeneral v-bind:overlayLoading="overlayLoading" />
        <!-- FormulaAnteojosController.php -->
        <v-card elevation="2" class="negativovMarginTopImprimir">
            <h5 style="position: absolute; right: 0; padding-right: 20px;">Historia Clinica - {{ consecutivoHistorialClinico }}</h5>
            <h3 style="position: relative;" class="text-center">EVOLUCIÓN - {{ evo_consecutivo }}</h3>
            <!-- FORMULA ANTEOJOS -->

            <!-- Datos del paciente -->
            <h4 class="ml-5">Datos del Paciente</h4>

            <v-row class="ml-1 mr-1 pt-5">
                <v-col cols="6" sm="3">
                    <v-text-field
                        type="date"
                        v-model="form.evo_fecha_diligenciamiento"
                        :error-messages="errors.evo_fecha_diligenciamiento"
                        title="Fecha de diligenciamiento evolución"
                        dense
                        label="Fecha de diligenciamiento evolución"
                    ></v-text-field>
                </v-col>
                <v-col cols="6" sm="3">
                    <v-text-field
                        v-model="numero_documento"
                        label="Número de Documento"
                        dense
                        disabled
                    ></v-text-field>
                </v-col>
                <v-col cols="6" sm="3">
                    <v-text-field
                        v-model="nombre"
                        label="Nombre"
                        dense
                        disabled
                    ></v-text-field>
                </v-col>
                <v-col cols="6" sm="3">
                    <v-text-field
                        v-model="apellido"
                        label="Apellido"
                        dense
                        disabled
                    ></v-text-field>
                </v-col>

                <!-- siguiente linea -->
                <v-col cols="6" sm="3">
                    <v-text-field
                        type="date"
                        v-model="fecha_nacimiento"
                        dense
                        label="Fecha nacimiento"
                        disabled
                    ></v-text-field>
                </v-col>
                <v-col cols="6" sm="3">
                    <v-text-field
                        v-model="edad"
                        label="Edad"
                        dense
                        disabled
                    ></v-text-field>
                </v-col>
            </v-row>

            <v-row class="ml-1 mr-1">
                <v-col cols="12" class="pb-0">
                    <v-textarea
                        v-model="form.evo_descripcion_evolucion"
                        :error-messages="errors.evo_descripcion_evolucion"
                        rows="8"
                        outlined
                        label="Descripción Evolución"
                        title="Por favor aqui digite descripción Evolución"
                        auto-grow
                    ></v-textarea>
                </v-col>

                <v-col cols="12" sm="6" class="pb-0 pt-0">
                    <v-textarea
                        v-model="form.evo_tratamiento"
                        :error-messages="errors.evo_tratamiento"
                        rows="2"
                        outlined
                        label="Tratamiento"
                        auto-grow
                    ></v-textarea>
                </v-col>

                <v-col cols="12" sm="6" class="pb-0 pt-0">
                    <v-textarea
                        v-model="form.evo_orden_medica"
                        :error-messages="errors.evo_orden_medica"
                        rows="2"
                        outlined
                        label="Orden Medica"
                        auto-grow
                    ></v-textarea>
                </v-col>
            </v-row>

            <!-- START RX -->
            <rxComponent
                @on:rx="fnActualizarform"
                :limpiarFormRx="limpiarFormRx"
                :errors="errors"
                :setFormRx="setFormRx">
            </rxComponent>
            <!-- END RX -->

            <firmaFormulario/>

            <v-row class="pl-4 pr-4 parte1">
                <!-- BOTONES ACCIONES  -->
                <v-col cols="12" sm="6">
                    <v-btn
                        type="button"
                        small
                        color="red darken-4"
                        class="white--text text-none"
                        tile
                        v-on:click="fnDescargarPdfEvolucion('formula')"
                        v-if="cAccion == 'Actualizar'"
                        :disabled="!$can(['EDITAR'])"
                    >
                        Imprimir formula
                        <v-icon right> picture_as_pdf </v-icon>
                    </v-btn>
                    <v-btn
                        type="button"
                        small
                        color="red darken-4"
                        class="white--text text-none"
                        tile
                        v-on:click="fnAbrirModalImprimirOrdenMedica(true)"
                        v-if="cAccion == 'Actualizar'"
                        :disabled="!$can(['EDITAR'])"
                    >
                        Imprimir Orden Medica
                        <v-icon right> picture_as_pdf </v-icon>
                    </v-btn>
                </v-col>
                <v-col cols="12" sm="6" class="d-flex justify-end">

                    <v-btn
                        type="button"
                        small
                        color="yellow darken-4"
                        class="white--text text-none mr-3"
                        tile
                        v-on:click="$refs.isOpenModal.fnIsOpenModal(true);"
                        :disabled="!$can(['EDITAR'])"
                    >
                        Reporte Evoluciones
                        <v-icon right> picture_as_pdf </v-icon>
                    </v-btn>

                    <v-btn
                        type="button"
                        small
                        color="grey"
                        class="white--text text-none mr-3"
                        tile
                        v-on:click="fnImprimirFormulario()"
                        v-if="cAccion == 'Actualizar'"
                        :disabled="!$can(['EDITAR'])"
                    >
                        Imprimir formulario
                        <v-icon right> print </v-icon>
                    </v-btn>
                    <v-btn
                        type="button"
                        small
                        color="red darken-4"
                        class="white--text text-none mr-3"
                        tile
                        @click="fnLimpiarCampos"
                    >
                        <v-icon left> format_clear </v-icon>Limpiar
                    </v-btn>
                    <v-btn
                        type="button"
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
        <v-row class="parte1">
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
                        :disabled="!$can(['LISTAR']) || loading"
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
                    <template v-slot:item.acciones="{ item }">
                        <v-icon
                            color="primary"
                            class="mr-2"
                            @click="fnShow(item.evo_id)"
                            title="Editar Evolución"
                            v-if="$can(['VER', 'EDITAR'])"
                        >
                            mdi-pencil
                        </v-icon>
                        <v-icon
                            color="red"
                            title="Eliminar Evolución."
                            @click="fnDestroy(item)"
                            v-if="$can(['ELIMINAR'])"
                        >
                            mdi-delete
                        </v-icon>
                    </template>
                </v-data-table>
            </v-col>
        </v-row>
        <!-- end Data table -->

        <modalOrdenMedicaPdf ref="modalOrdenMedicaPdfEtiqueta" @fnDescargarPdf="fnDescargarPdfEvolucion"></modalOrdenMedicaPdf>

        <modal ref="isOpenModal" >
            <template v-slot:header>
                <h3>
                    Reporte Evoluciones
                </h3>
            </template>
            <template v-slot:body>
                <table style="width: 100%; border-collapse: collapse;">
                    <tr>
                        <td>
                            <v-subheader class="pr-0 pl-0">Del:</v-subheader>
                        </td>
                        <td>
                            <v-text-field
                                type="date"
                                v-model="fechaDel"
                                label="Fecha inicial"
                                dense>
                            </v-text-field>
                        </td>
                        <td>
                            <v-subheader class="pr-0 pl-1">Al:</v-subheader>
                        </td>
                        <td>
                            <v-text-field
                                type="date"
                                v-model="fechaAl"
                                label="Fecha final"
                                dense>
                            </v-text-field>
                        </td>
                    </tr>
                </table>
            </template>
            <template v-slot:footer>
                <div>
                    <v-btn
                        type="button"
                        small
                        color="green"
                        class="white--text text-none mr-1"
                        :disabled="!$can(['EDITAR'])"
                        v-on:click="fnDescargarPdfEvolucion('reporte_evoluciones')"
                    >
                        Generar
                        <v-icon right> picture_as_pdf </v-icon>
                    </v-btn>
                </div>
            </template>
        </modal>
    </div>
</template>
<script>
import loadingGeneral from "../../loadingGeneral/loadingGeneral.vue";
import firmaFormulario from "../../commons/firma-formulario.vue";
import modalOrdenMedicaPdf from "../../commons/modalOrdenMedicaPdf.vue";
import rxComponent from "../../commons/rx.vue";
import modal from "../../commons/modal.vue";
export default {
    props: {
        idHistoriaClinica: {
            type: Number,
            default: 0,
        },
        consecutivo: {
            type: String,
            default: "",
        },
    },
    components: {
        loadingGeneral,
        firmaFormulario,
        modalOrdenMedicaPdf,
        rxComponent,
        modal
    },
    watch: {
        errors: {
            deep: true, //  Vue observará todos los cambios en las propiedades anidadas del objeto en lugar de solo observar el objeto en sí mismo.
            handler(errors) {
                this.$emit('errors', errors)
            }
        },
        limpiarFormRx: {
            deep: true, //  Vue observará todos los cambios en las propiedades anidadas del objeto en lugar de solo observar el objeto en sí mismo.
            handler(value) {
                this.$emit('limpiarFormRx', value)
            }
        },
        setFormRx: {
            deep: true, //  Vue observará todos los cambios en las propiedades anidadas del objeto en lugar de solo observar el objeto en sí mismo.
            handler(newValue) {
                this.$emit('setFormRx', newValue)
            }
        },
    },
    data() {
        return {
            consecutivoHistorialClinico : "",

            /* Variables Table. */
            debounce: null,
            buscar: "",
            page: 1,
            totalRegistros: 0,
            loading: false,
            overlayLoading : false,
            options: {},
            headers: [
                { text: "Consecutivo", value: "evo_consecutivo" },
                { text: "Fecha Diligenciado", value: "evo_fecha_diligenciamiento" },
                { text: "Descripción Evolución", value: "evo_descripcion_evolucion" },
                { text: "Fecha Modificado", value: "updated_at" },
                { text: "Acciones", value: "acciones", sortable: false },
            ],
            dataSet: [],
            contador : 0,

            cAccion: "Guardar",
            // Json para campos formulario.
            form: {
                evo_id: "",
                evo_fecha_diligenciamiento: "",
                evo_descripcion_evolucion: "",
                evo_tratamiento: "",
                evo_orden_medica: "",
            },
            // Datos del paciente
            id_paciente : "",
            numero_documento: "",
            nombre: "",
            apellido: "",
            fecha_nacimiento: "",
            edad: "",

            evo_consecutivo: "0000",

            // Variable de error campos
            errors: "",

            overlayLoading: false,

            // Variable para indicar si se debe limpiar formulario de rx
            limpiarFormRx: 0,
            setFormRx: {}, // Form RX

            // Reporte Evoluciones
            fechaDel: '',
            fechaAl: ''
        };
    },
    methods: {
        filterSearch() {
            clearTimeout(this.debounce);
            this.debounce = setTimeout(() => {
                this.fnBuscar();
            }, 600);
        },
        fnAccion(){
            if (this.cAccion === "Guardar") {
                this.fnStore();
            }else{
                this.fnUpdate();
            }
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
                    `/consultorio-oftamologico/historia-clinica/listar/evolucion/${this.$route.params.numero_documento}?length=${length}&start=${start}&orderColumn=${sortBy}&order=${sortDesc}&buscar=${this.buscar}&evo_id_historia_clinica=${this.idHistoriaClinica}`
                )
                .then((response) => {
                    this.totalRegistros = response.data.total;

                    let data = response.data.data
                    let getDataPaciente   = data[0].get_paciente;
                    this.numero_documento = getDataPaciente.numero_documento;
                    this.nombre           = getDataPaciente.nombre;
                    this.apellido         = getDataPaciente.apellido;
                    this.fecha_nacimiento = getDataPaciente.fecha_nacimiento;
                    this.edad             = getDataPaciente.edad;

                    this.id_paciente      = getDataPaciente.id;

                    this.form.numero_documento   = this.$route.params.numero_documento;
                    for (let i = 0; i < this.totalRegistros; i++) {
                        if (data[i].evo_descripcion_evolucion != null && data[i].evo_descripcion_evolucion != "") {
                            data[i].evo_descripcion_evolucion  = data[i].evo_descripcion_evolucion.substr(0,20);
                        }
                        data[i].id_paciente      = data[i].get_paciente.id;
                        data[i].numero_documento = data[i].get_paciente.numero_documento;
                        delete data[i].get_paciente;
                    }

                    this.dataSet = data;

                    this.loading = false;
                    if (this.contador == 0) {
                        this.contador++;
                        this.fnConsecutivoEvolucion();
                    }
                    this.overlayLoading = false;
                })
                .catch((errors) => {
                    this.overlayLoading = false;
                    this.loading = false;
                    this.dataSet = [];
                });
        },
        fnShow(evo_id){
            this.overlayLoading = true;
            this.cAccion = "Actualizar";
            axios
                .get(`/consultorio-oftamologico/historia-clinica/mostrar/evolucion/${evo_id}`)
                .then((response) => {
                    let data = response.data.data;

                    this.evo_consecutivo = data.evo_consecutivo;

                    this.form.evo_id                        = data.evo_id;
                    this.form.evo_fecha_diligenciamiento    = data.evo_fecha_diligenciamiento;
                    this.form.evo_descripcion_evolucion     = data.evo_descripcion_evolucion;
                    this.form.evo_tratamiento               = data.evo_tratamiento;
                    this.form.evo_orden_medica              = data.evo_orden_medica;

                    this.setFormRx = {
                        rx_od       : data.evo_rx_od,
                        rx_oi       : data.evo_rx_oi,
                        adicion     : data.evo_adicion,
                        dp          : data.evo_dp,
                        observacion : data.evo_observacion
                    };
                    this.fnActualizarform(this.setFormRx);

                    this.errors = "";
                    this.overlayLoading = false;
                })
                .catch((errores) => {
                    this.errors = this.fnResponseError(errores);
                    this.overlayLoading = false;
                });
        },
        fnStore(){
            let formData = new FormData();
            for (let key in this.form) {
                if (this.form[key] == null) {
                    this.form[key] = '';
                }
                formData.append(key, this.form[key]);
            }
            formData.append('numero_documento', this.numero_documento);
            formData.append('evo_id_historia_clinica', this.idHistoriaClinica);

            this.overlayLoading = true;
            axios
                .post(`/consultorio-oftamologico/historia-clinica/guardar/evolucion`, formData)
                .then((response) => {
                    this.errors = "";
                    this.$swal(
                        response.data.message,
                        '',
                        'success'
                    );
                    this.fnBuscar();
                    this.fnLimpiarCampos();
                    this.overlayLoading = false;
                })
                .catch((errores) => {
                    this.errors = this.fnResponseError(errores);
                    this.overlayLoading = false;
                });
        },
        fnUpdate(){
            this.overlayLoading = true;

            axios
                .post(`/consultorio-oftamologico/historia-clinica/actualizar/evolucion/${this.form.evo_id}`, this.form)
                .then((response) => {
                    this.errors = "";
                    this.$swal(
                        response.data.message,
                        '',
                        'success'
                    );
                    this.fnBuscar();
                    this.fnLimpiarCampos();
                    this.overlayLoading = false;
                })
                .catch((errores) => {
                    this.errors = this.fnResponseError(errores);
                    this.overlayLoading = false;
                });
        },
        fnDestroy(item){
            this.$swal({
                title: 'Seguro que quiere eliminar la Evolución seleccionada?',
                text: `Evolución No.${item.evo_consecutivo}!`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si, Eliminar!'
            }).then((result) => {
                if (result.isConfirmed) {
                    this.overlayLoading = true;
                    axios.post(`/consultorio-oftamologico/historia-clinica/delete/evolucion/${item.evo_id}`)
                    .then((response) => {
                        this.errors = "";
                        this.$swal(
                            response.data.message,
                            '',
                            'success'
                        );
                        this.fnBuscar();
                        this.fnLimpiarCampos();
                        this.overlayLoading = false;
                    })
                    .catch((errores) => {
                        this.errors = this.fnResponseError(errores);
                        this.overlayLoading = false;
                    });
                }
            });
        },
        fnConsecutivoEvolucion() {
            this.overlayLoading = true;
            axios
                .get(`/consultorio-oftamologico/historia-clinica/consecutivo/evolucion?evo_id_paciente=${this.id_paciente}&evo_id_historia_clinica=${this.idHistoriaClinica}`)
                .then((response) => {
                    this.evo_consecutivo = response.data;
                    this.overlayLoading = false;
                })
                .catch((errores) => {
                    this.errors = this.fnResponseError(errores);
                    this.overlayLoading = false;
                });
        },
        fnRegresarHistoriaClinica() {
            this.$router.push({
                name: "historia-clinica/formula-anteojos",
                params: {
                    numero_documento: this.$route.params.numero_documento,
                    idHistoriaClinica: this.idHistoriaClinica,
                },
            });
        },
        fnDescargarPdfEvolucion(reporte = '', info_centro = ''){
            let data = {};

            switch (reporte) {
                case 'orden_medica':
                    data.mostrar_info_centro = info_centro
                    this.fnAbrirModalImprimirOrdenMedica(false)
                break;
                case 'reporte_evoluciones':
                    if (this.fechaAl == "" || this.fechaDel == "") {
                        this.$swal({
                            icon: 'error',
                            title: `Validación Reporte Evoluciones`,
                            text: `La fecha Al y Del no pueden ser vacías.`,
                        })
                        return;
                    }
                    data.fechaDel                   = this.fechaDel;
                    data.fechaAl                    = this.fechaAl;
                    data.evo_id_historia_clinica    = this.idHistoriaClinica
                    data.consecutivoHistoriaClinica = this.consecutivoHistorialClinico
                break;
            }

            this.overlayLoading = true;

            data.tipo_reporte    = reporte;
            data.numero_documento= this.$route.params.numero_documento;
            data.evo_id          = this.form.evo_id;

            axios
                .post(`/consultorio-oftamologico/historia-clinica/pdf/evolucion`,data,  {responseType: 'blob',})
                .then((response) => {
                    let hoy = new Date();
                    let fecha = hoy.getDate() +""+ ( hoy.getMonth() + 1 ) +""+  hoy.getFullYear();
                    let hora = hoy.getHours() +""+  hoy.getMinutes() +""+  hoy.getSeconds();
                    const nombrePDF = this.$route.params.numero_documento+"_"+reporte.toUpperCase()+"_"+fecha+""+hora+".pdf";

                    const url = window.URL.createObjectURL(new Blob([response.data]));
                    const link = document.createElement('a');
                    link.href= url;
                    link.setAttribute('download', nombrePDF);
                    document.body.appendChild(link);
                    link.click();

                    switch (reporte) {
                        case 'reporte_evoluciones':
                            this.$refs.isOpenModal.fnIsOpenModal(false);
                        break;
                    }

                    this.overlayLoading = false;
                })
                .catch((errores) => {
                    switch (reporte) {
                        case 'reporte_evoluciones':
                            if (errores.response != undefined && errores.response.status == 422) {
                                this.$swal({
                                    icon: 'info',
                                    title: `Por favor diligencie correctamente fechas Al y Del de Reporte Evoluciones.`,
                                    text: ``,
                                })
                            }

                            if (errores.response != undefined && errores.response.status == 404) {
                                this.$swal({
                                    icon: 'info',
                                    title: `No se encontraron evoluciones para generar reporte, Intente nuevamente.`,
                                    text: ``,
                                })
                            }
                        break;
                        default:
                            this.$swal({
                                icon: 'error',
                                title: ``,
                                text: `Error inesperado al generar PDF.`,
                            })
                        break;
                    }

                    this.overlayLoading = false;
                });
        },
        fnAbrirModalImprimirOrdenMedica(val){
            this.$refs.modalOrdenMedicaPdfEtiqueta.fnAbrirModalImprimirOrdenMedicaLocal(val);
        },
        fnLimpiarCampos(){
            this.fnConsecutivoEvolucion()
            this.cAccion = "Guardar";
            this.form.evo_id                        = "";
            this.form.evo_fecha_diligenciamiento    = "";
            this.form.evo_descripcion_evolucion     = "";
            this.form.evo_tratamiento               = "";
            this.form.evo_orden_medica              = "";

            this.limpiarFormRx++; // auto incremental para que se active el watch y limpie campos de rx, sin necesidad de estar asignando otros valores
        },
        fnImprimirFormulario(){
            window.print();
        },
        fnActualizarform(formRx){
            this.form = {...this.form,...formRx}
        }
    },
    mounted() {
        this.consecutivoHistorialClinico = this.$route.params.consecutivo;
        if (this.idHistoriaClinica == 0) {
            this.fnRegresarHistoriaClinica();
        }else{
            this.fnBuscar();
        }
    },
};
</script>
