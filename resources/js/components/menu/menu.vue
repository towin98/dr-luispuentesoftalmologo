<template>
    <div>
        <v-app id="inspire">
            <loadingGeneral v-bind:overlayLoading="overlayLoading" />
            <v-app-bar app clipped-left style="background: #9ecce3;" class="parte1">
                <v-spacer></v-spacer>
                <v-btn style="background: #00bcd4" class="white--text mr-1" rounded small>
                    <v-icon> date_range </v-icon>{{ date }}
                </v-btn>

                <!-- NOTIFICACIONES -->
                <v-menu offset-y max-width="550" max-height="400" class="overflow-y-auto" :close-on-content-click="false" v-if="this.infoUser.rol == 'MEDICO'">
                    <template v-slot:activator="{ on, attrs }">
                        <v-badge
                            :content="notificacionesSinLeer"
                            :value="notificacionesSinLeer"
                            overlap
                            color="red"
                        >
                            <v-btn
                                color="dark"
                                icon
                                small
                                v-bind="attrs" v-on="on"
                                :disabled="disabledNotificacionCita"
                                title="Notiticaciones de citas prioritarias">
                                <v-icon large>notifications</v-icon>
                            </v-btn>
                        </v-badge>
                    </template>
                    <v-list>
                        <v-list-item>
                            <v-list-item-content class="pt-0 pb-1">
                                <div class="text-center mt-1 font-weight-bold" v-text="'NOTIFICACIONES'"></div>
                                <v-divider class="mx-1"></v-divider>
                            </v-list-item-content>
                        </v-list-item>
                        <v-list-item
                            v-for="(item, i) in itemsNotifiaciones"
                            :key="i"
                        >
                            <v-img
                                :src="'../../'+item.get_paciente.foto"
                                class="mr-4"
                                max-width="64"
                                min-width="64"
                                v-if="item.get_paciente.foto != ''"
                            ></v-img>

                            <v-img
                                src="http://jago.co.nz/assets/camaleon_cms/image-not-found-4a963b95bf081c3ea02923dceaeb3f8085e1a654fc54840aac61a57a60903fef.png"
                                class="mr-4"
                                max-width="64"
                                min-width="64"
                                v-else
                            ></v-img>

                            <v-list-item-content class="pt-0 pb-1">
                                <v-divider v-if="i > 0" class="mx-1"></v-divider>
                                <span class="text-uppercase text-caption">
                                    CITA PRIORITARIA: {{ item.fecha_cita }} {{ item.hora_cita }}
                                </span>
                                <div>El paciente {{ item.get_paciente.nombre }} {{ item.get_paciente.apellido }} con C.C {{ item.get_paciente.numero_documento }} requiere ser atentido con prioridad.</div>
                                <div v-if="item.observacion != '' && item.observacion != null">Observación: <b class="text-lowercase">{{item.observacion}}</b></div>
                                <div class="mt-2 text-caption" v-text="'SEGUIR'"></div>
                                <div class="d-flex">
                                    <div class="d-flex justify-start" style="width: 50%;">
                                        <v-btn x-small rounded color="red" dark @click="fnSeguirPacienteCita(item, i)" v-if="item.prioridad_aceptado == null">
                                            SI
                                        </v-btn>
                                        <v-btn x-small rounded color="primary" dark @click="fnSeguirPacienteCita(item, i)" v-if="item.prioridad_aceptado != null">
                                            NO
                                        </v-btn>
                                    </div>
                                    <div class="d-flex justify-end" style="width: 50%;">
                                        <v-btn x-small rounded color="primary" dark @click="fnLeerNotitifacionCita(item, i)">
                                            {{ item.get_alerta_cita.leido == null ? 'Marcar como leída✔️' : 'Marcar como no leida✔️✔️'}}
                                        </v-btn>
                                    </div>
                                </div>
                            </v-list-item-content>
                        </v-list-item>
                        <v-list-item>
                            <v-list-item-content class="pt-0 pb-0">
                                <v-btn
                                    small
                                    title="Cargar notificaciones anteriores"
                                    color="grey"
                                    plain
                                    @click="fnListarNotificacionesCitas('FIN')"
                                    :disabled="disabledNotificacionCita">
                                    Ver más
                                </v-btn>
                            </v-list-item-content>
                        </v-list-item>
                    </v-list>
                </v-menu>

                <v-menu offset-y rounded="lg">
                    <template v-slot:activator="{ on, attrs }">
                        <v-btn
                            v-bind="attrs"
                            v-on="on"
                            style="background: #9ecce3"
                            class="ml-2"
                            small
                            elevation="0">
                            <v-icon size="40"> account_circle </v-icon>
                                {{ infoUser.name }}
                            <v-icon size="40"> arrow_drop_down </v-icon>
                        </v-btn>
                    </template>
                    <v-list class="pt-0 pb-0">
                        <v-list-item>
                            <v-list-item-title class="text-center font-weight-bold">{{ infoUser.rol }}</v-list-item-title>
                        </v-list-item>
                        <v-list-item link :to="{name: 'roles-permisos'}" v-on:click="titleProceso = 'Roles Permisos'; pathPrevious = ''" v-if="moduloRolesPermisos">
                            <v-list-item-title>
                                <v-icon size="20"> settings </v-icon>Roles y Permisos
                            </v-list-item-title>
                        </v-list-item>
                        <v-list-item link :to="{name: 'auditoria-sistema'}" v-on:click="titleProceso = 'Auditoria Sistema'; pathPrevious = ''">
                            <v-list-item-title>
                                <v-icon size="20"> auto_stories </v-icon> Auditoría del Sistema
                            </v-list-item-title>
                        </v-list-item>
                        <v-list-item link :to="{name: 'cambio-clave'}" v-on:click="titleProceso = 'Cambio contraseña'; pathPrevious = ''">
                            <v-list-item-title>
                                <v-icon size="20"> password </v-icon> Cambiar contraseña
                            </v-list-item-title>
                        </v-list-item>
                        <v-list-item v-on:click="logout">
                            <v-list-item-title>
                                <v-icon size="20"> logout </v-icon> Cerrar Sesión
                            </v-list-item-title>
                        </v-list-item>
                    </v-list>
                </v-menu>

                <template v-slot:extension>
                    <v-tabs centered class="ml-n9" style="background: #1000e1">
                        <v-tab :to="{ name: 'inicio' }" class="white--text" v-on:click="titleProceso = 'Inicio'; pathPrevious = ''">Inicio</v-tab>

                        <!-- Ingresar -->
                        <v-menu offset-y rounded="lg"  v-if="moduloCrearPaciente">
                            <template v-slot:activator="{ on, attrs }">
                                <v-tab
                                    v-bind="attrs"
                                    v-on="on"
                                    class="white--text">
                                    Ingresar
                                    <v-icon right color="white">
                                        mdi-menu-down
                                    </v-icon>
                                </v-tab>
                            </template>

                            <v-list>
                                <v-list-item :to="{ name: 'crear-paciente' }" v-if="moduloCrearPaciente" v-on:click="titleProceso = 'Crear Paciente'; pathPrevious = ''">
                                    <v-list-item-title>Crear Paciente</v-list-item-title>
                                </v-list-item>
                            </v-list>
                        </v-menu>

                        <!-- Historia Clinica -->
                        <v-tab
                            v-if="moduloHistoriaClinica"
                            :to="{ name: 'historia-clinica' }"
                            class="white--text"
                            v-on:click="titleProceso = 'Historia Clinica'; pathPrevious = 'historia-clinica'">
                            Historia Clinica
                        </v-tab>

                        <!-- Agenda -->
                        <v-menu offset-y rounded="lg"  v-if="moduloAgenda">
                            <template v-slot:activator="{ on, attrs }">
                                <v-tab
                                    v-bind="attrs"
                                    v-on="on"
                                    class="white--text">
                                    Agenda
                                    <v-icon right color="white">
                                        mdi-menu-down
                                    </v-icon>
                                </v-tab>
                            </template>

                            <v-list>
                                <v-list-item :to="{ name: 'agenda/cita-cliente' }" v-if="moduloCitaCliente" v-on:click="titleProceso = 'Agenda/Cita Cliente'; pathPrevious = ''">
                                    <v-list-item-title>Cita Cliente</v-list-item-title>
                                </v-list-item>
                                <v-list-item :to="{ name: 'agenda/informe-cita' }" v-if="moduloInformeCita" v-on:click="titleProceso = 'Agenda/Informe Cita'; pathPrevious = ''">
                                    <v-list-item-title>Informe Cita</v-list-item-title>
                                </v-list-item>
                            </v-list>
                        </v-menu>

                        <!-- Parametros -->
                        <v-menu v-if="moduloParametros" offset-y rounded="lg">
                            <template v-slot:activator="{ on, attrs }">
                                <v-tab
                                    v-bind="attrs"
                                    v-on="on"
                                    class="white--text"
                                    title="Campos Parámetros del Sistema">
                                    PARÁMETROS
                                    <v-icon right color="white">
                                        mdi-menu-down
                                    </v-icon>
                                </v-tab>
                            </template>

                            <v-list class=" lighten-3">
                                <v-list-item :to="{ name: 'parametros/eps' }" v-if="moduloEps"  v-on:click="titleProceso = 'Parametros/Eps'; pathPrevious = ''">
                                    <v-list-item-title>Eps</v-list-item-title>
                                </v-list-item>
                            </v-list>
                        </v-menu>

                    </v-tabs>
                </template>
            </v-app-bar>
            <v-main>
                <v-container >
                    <menuHeader v-bind:proceso="titleProceso" v-bind:pathPrevious="pathPrevious"></menuHeader>
                    <router-view></router-view>
                </v-container>
            </v-main>
        </v-app>
    </div>
</template>
<script>
window.Vue = require("vue").default;
import menuHeader from "./header.vue";
import loadingGeneral from "../loadingGeneral/loadingGeneral.vue";
import permisos from "../rolPermission/Permissions.vue";
import { commons }  from '../commons/commons.js';
Vue.mixin(permisos);
Vue.mixin(commons);
export default {
    components: {
        loadingGeneral,
        menuHeader
    },
    data() {
        return {

            token: localStorage.getItem("token_Historial_Clinico_Oftamologico"),
            date : "",

            // Variables permisos menus start
            moduloCrearPaciente           : false,
            moduloHistoriaClinica         : false,
            // Variables para menu agenda.
            moduloAgenda                  : false,
            moduloCitaCliente             : false,
            moduloInformeCita             : false,
            // Variables para menu agenda.

            /* Variables de configuracion del sistema */
            moduloParametros              : false,
            moduloEps                     : false,
            moduloRolesPermisos           : false,
            /* Variables de configuracion del sistema */

            // Variables permisos menus end

            infoUser : {
                rol  : '',
                name : ''
            },
            intervalId: 0,

            titleProceso : "",
            pathPrevious : "",
            overlayLoading: false,

            // VARIABLES NOTIFICACIONES
            itemsNotifiaciones: [],
            notificacionesSinLeer: 0,
            citasConNotificacion : 0,
            disabledNotificacionCita : false,
            intervalIdCantidadNotificacionesCitas: 0,
            intervalIdFnNotificacionCitasPrioritariasACeptadas : 0,
            contadorCitas : 0
        };
    },
    methods:{
        logout() {
            this.overlayLoading = true;
            axios
                .post("/consultorio-oftalmologico/logout")
                .then((response) => {
                    clearInterval(this.intervalId);
                    clearInterval(this.intervalIdCantidadNotificacionesCitas);
                    clearInterval(this.intervalIdFnNotificacionCitasPrioritariasACeptadas);
                    localStorage.removeItem("token_Historial_Clinico_Oftamologico");
                    this.$router.push("/");
                    this.overlayLoading = false;
                })
                .catch((errors) => {
                    clearInterval(this.intervalId);
                    clearInterval(this.intervalIdCantidadNotificacionesCitas);
                    clearInterval(this.intervalIdFnNotificacionCitasPrioritariasACeptadas);
                    localStorage.removeItem("token_Historial_Clinico_Oftamologico");
                    this.$router.push("/");
                    this.overlayLoading = false;
                });
        },
        fnLeerNotitifacionCita(item, index){
            this.overlayLoading = true;
            axios
                .post(`/consultorio-oftalmologico/notificacion-citas/leer/${item.id_alerta_cita}`)
                .then((response) => {
                    this.itemsNotifiaciones[index].get_alerta_cita.leido = item.get_alerta_cita.leido == null ? 'SI' : null;
                })
                .catch((errores) => {
                    this.fnResponseError(errores);
                })
                .finally(() => (this.overlayLoading = false));
        },
        fnSeguirPacienteCita(item, index){
            this.overlayLoading = true;
            axios
                .post(`/consultorio-oftalmologico/agenda/seguir-cita/${item.id}`)
                .then((response) => {
                    this.itemsNotifiaciones[index].prioridad_aceptado = item.prioridad_aceptado == null ? 'SI' : null;
                })
                .catch((errores) => {
                    this.fnResponseError(errores);
                })
                .finally(() => (this.overlayLoading = false));
        },

        /**
         * Método que busca notificiones anteriores para pintar.
         *
         * @param {string} listar Parametro para determinar si el metodo es ejecutado al iniciar el componente o durante el transcurso.
         * @param {number} limit  Parametro para saber si se debe hacer consulta con un limit especifico.
         */
        fnListarNotificacionesCitas(listar = 'FIN', limit = 0){
            if (this.infoUser.rol != "MEDICO") return;

            this.disabledNotificacionCita = true;
            const data = {
                length : limit == 0 ? 3 : limit,
                start  : limit == 0 ? this.itemsNotifiaciones.length      : 0
            };
            axios
                .get(`/consultorio-oftalmologico/notificacion-citas/listar-alertas-citas?start=${data.start}&length=${data.length}&listar=SI`)
                .then((response) => {
                    for (let i = 0; i < response.data.data.length; i++) {
                        if (listar == 'INI' || listar == 'FIN' && limit == 0) {
                            // Aquí es cuando inicia la app en el módulo.
                            this.notificacionesSinLeer    = response.data.notificacionesSinLeer;
                            this.citasConNotificacion     = response.data.citasConNotificacion;
                            this.itemsNotifiaciones.push(response.data.data[i]);
                        }else{
                            this.$notification.dark(`El paciente ${ response.data.data[i].get_paciente.nombre } ${ response.data.data[i].get_paciente.apellido } con C.C ${ response.data.data[i].get_paciente.numero_documento } requiere ser atentido con prioridad.`, {
                                title: `CITA PRIORITARIA: ${response.data.data[i].fecha_cita } ${response.data.data[i].hora_cita }`,
                                // timer: 20,
                                infiniteTimer: true,
                                showLeftIcn: true,
                                showCloseIcn: true,
                                position: "bottomRight"
                            });

                            this.itemsNotifiaciones.unshift(response.data.data[i]);
                        }
                    }
                    this.disabledNotificacionCita = false;
                })
                .catch((errores) => {
                    this.fnResponseError(errores);
                });
        },
        /**
         * Método con el objtivo de consultar notificaciones Sin Leer y citas Con Notificacion
         */
        fnCantidadNotificacionesCitas(){
            // Listar notificaciones citas
            if (this.contadorCitas == 0) {this.fnListarNotificacionesCitas('INI');}

            if (this.contadorCitas > 0) {
                axios
                    .get(`/consultorio-oftalmologico/notificacion-citas/listar-alertas-citas`)
                    .then((response) => {
                        // Si hay mas notificaciones de citas en BD que en el frontend se cargan
                        if (response.data.citasConNotificacion > this.citasConNotificacion) {
                            const limit = response.data.citasConNotificacion - this.citasConNotificacion;
                            this.fnListarNotificacionesCitas('FIN', limit);
                        }

                        if(response.data.citasConNotificacion < this.citasConNotificacion){
                            this.itemsNotifiaciones = [];
                            this.fnListarNotificacionesCitas('INI'); // Listar notificaciones citas
                        }

                        this.notificacionesSinLeer    = response.data.notificacionesSinLeer;
                        this.citasConNotificacion     = response.data.citasConNotificacion;
                    })
                    .catch((errores) => {
                        this.fnResponseError(errores);
                    });
            }

            this.contadorCitas++;
        },
        /**
         * Método que consulta las citas prioritarias aceptadas por un rango de fecha (entre 20 segundos), esto con el fin de hacer
         * solicitudes cada 60 segundos para simular tiempo real y generar notificaciones.
         */
        fnNotificacionCitasPrioritariasACeptadas(){
            axios
                .get(`/consultorio-oftalmologico/notificacion-citas/prioritarias-aceptadas`)
                .then((response) => {
                    const data = response.data.data;
                    for (let i = 0; i < response.data.data.length; i++) {
                        this.$notification.dark(`La cita requerida, fecha: ${data[i].fecha_cita } ${ data[i].hora_cita } de ${ data[i].get_paciente.nombre } ${ data[i].get_paciente.apellido } con C.C ${ data[i].get_paciente.numero_documento } ha sido ACEPTADA.`, {
                            title: `SEGUIR`,
                            // timer: 20,
                            infiniteTimer: true,
                            showLeftIcn: true,
                            showCloseIcn: true,
                            position: "bottomRight"
                        });
                    }
                })
                .catch((errores) => {
                    this.fnResponseError(errores);
                });
        }
    },
    async created() {
        const fecha = new Date();
        const month = fecha.toLocaleString("es-CO", { month: "long" });

        this.date = `${month.substring(0, 3)}/${fecha.getFullYear()}`;
        window.axios.defaults.headers.common["Authorization"] = `Bearer ${this.token}`;

        // Obteniendo nombre de la ruta.
        if (this.$route.name) {
            switch (this.$route.name) {
                case 'historia-clinica':
                case 'historia-clinica/motivo-consulta':
                case 'historia-clinica/formula-anteojos':
                case 'historia-clinica/cargar-archivo':
                    this.pathPrevious = 'historia-clinica';
                    this.titleProceso = 'Historia Clinica';
                break;
                default:
                    this.titleProceso = this.$route.name.replace("-", " ");
                break;
            }
        }

        switch (this.$route.name) {
            case 'roles-permisos':
                // Para esta vista no se consulta porque ya tiene el metodo $fnConsultaPermisosUsuario()
            break;
            default:
                this.overlayLoading = true;
                await this.$fnConsultaPermisosUsuario();
                this.overlayLoading = false;
            break;
        }

        /* DEPENDIENDO DEL ROL DEL USUARIO SE MUESTRA MENU. */
        this.overlayLoading = true;
        await this.informacionUsuario();
        this.overlayLoading = false;

        this.intervalId = setInterval(async () => {
            await this.informacionUsuario();
        }, 870000); // 14.5 min

        switch (this.infoUser.rol) {
            case "SECRETARIA":
                this.moduloCrearPaciente          = true;
                this.moduloHistoriaClinica        = true;
                this.moduloAgenda                 = true;
                this.moduloCitaCliente            = true;
                this.moduloInformeCita            = true;

                /* Variables de configuracion del sistema */
                this.moduloParametros             = true;
                this.moduloEps                    = true;
                /* fin Variables de configuracion del sistema */

                this.overlayLoading = true;
                this.intervalIdFnNotificacionCitasPrioritariasACeptadas = setInterval(() => {
                    this.fnNotificacionCitasPrioritariasACeptadas();
                }, 60000); // 60 s
                this.overlayLoading = false;

                break;
            case "MEDICO":
                this.moduloCrearPaciente          = true;
                this.moduloHistoriaClinica        = true;
                this.moduloAgenda                 = true;
                this.moduloCitaCliente            = true;
                this.moduloInformeCita            = true;

                /* Variables de configuracion del sistema */
                this.moduloParametros             = true;
                this.moduloEps                    = true;
                /* fin Variables de configuracion del sistema */

                this.fnCantidadNotificacionesCitas();
                this.intervalIdCantidadNotificacionesCitas = setInterval(() => {
                    this.fnCantidadNotificacionesCitas();
                }, 60000); // 60 s
            break;
            case "ADMINISTRADOR":
                this.moduloRolesPermisos          = true;
            break;
        }
    },
    mounted(){
    },
};
</script>
<style type="text/css" media="print">

    input {
        padding-left: 0px !important;
    }

    @media print {
        .negativovMarginTopImprimir {
            margin-top: -130px;
        }
        .parte1 {
            display:none;
        }
    }
</style>
