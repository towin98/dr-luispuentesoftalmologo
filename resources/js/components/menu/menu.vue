<template>
    <div>
        <v-app id="inspire">
            <loadingGeneral v-bind:overlayLoading="overlayLoading" />
            <v-app-bar app clipped-left style="background: #9ecce3;">
                <v-spacer></v-spacer>
                <v-btn style="background: #00bcd4" class="white--text" rounded>
                    <v-icon> date_range </v-icon>{{ date }}
                </v-btn>

                <v-menu offset-y rounded="lg">
                    <template v-slot:activator="{ on, attrs }">
                        <v-btn
                            v-bind="attrs"
                            v-on="on"
                            style="background: #9ecce3"
                            elevation="0">
                            <v-icon size="40"> account_circle </v-icon>
                                {{ infoUser.name }}
                            <v-icon size="40"> arrow_drop_down </v-icon>
                        </v-btn>
                    </template>
                    <v-list>
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
                        <v-tab
                            v-if="moduloTurno"
                            :to="{ name: 'turno' }"
                            class="white--text">
                            Turno
                        </v-tab>

                        <!-- Parametros -->
                        <v-menu
                            v-if="moduloParametros"
                            offset-y rounded="lg"
                        >
                            <template v-slot:activator="{ on, attrs }">
                                <v-tab
                                    v-bind="attrs"
                                    v-on="on"
                                    class="white--text"
                                    title="Campos Parámetros del Sistema">
                                    Parametros
                                    <v-icon right color="white">
                                        mdi-menu-down
                                    </v-icon>
                                </v-tab>
                            </template>

                            <v-list class=" lighten-3">
                                <v-list-item
                                    :to="{ name: 'medicina-prepagada' }"
                                    v-on:click="titleProceso = 'Medicina Prepagada'; pathPrevious = ''">
                                    <v-list-item-title>Medicina Prepagada</v-list-item-title>
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
import { rolesPermisos } from "../rolPermission/rolesPermisos.js";
import { commons }  from '../commons/commons.js';
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
            moduloInforme                 : false,
            // Variables para menu agenda.
            moduloAgenda                  : false,
            moduloCitaCliente             : false,
            moduloInformeCita             : false,
            // Variables para menu agenda.
            moduloTurno                   : false,

            /* Variables de configuracion del sistema */
            moduloParametros              : false,
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
        };
    },
    mixins: [rolesPermisos],
    methods:{
        logout() {
            this.overlayLoading = true;
            axios
                .post("/consultorio-oftamologico/logout")
                .then((response) => {
                    clearInterval(this.intervalId);
                    localStorage.removeItem("token_Historial_Clinico_Oftamologico");
                    this.$router.push("/");
                    this.overlayLoading = false;
                })
                .catch((errors) => {
                    clearInterval(this.intervalId);
                    localStorage.removeItem("token_Historial_Clinico_Oftamologico");
                    this.$router.push("/");
                    this.overlayLoading = false;
                });
        },

    },
    async created() {

        // Obteniendo nombre de la ruta.
        if (this.$route.name) {
            switch (this.$route.name) {
                case 'historia-clinica':
                case 'historia-clinica/motivo-consulta':
                case 'historia-clinica/formula-anteojos':
                case 'historia-clinica/antecedentes':
                case 'historia-clinica/cargar-archivo':
                    this.pathPrevious = 'historia-clinica';
                    this.titleProceso = 'Historia Clinica';
                break;
                default:
                    this.titleProceso = this.$route.name.replace("-", " ");
                break;
            }
        }

        const fecha = new Date();
        const month = fecha.toLocaleString("es-CO", { month: "long" });

        this.date = `${month.substring(0, 3)}/${fecha.getFullYear()}`;
        window.axios.defaults.headers.common[
            "Authorization"
        ] = `Bearer ${this.token}`;

        /* DEPENDIENDO DEL ROL DEL USUARIO SE MUESTRA MENU. */
        this.overlayLoading = true;
        await this.informacionUsuario();
        this.overlayLoading = false;

        this.intervalId = setInterval(async () => {
            await this.informacionUsuario();
        }, 20000);

        switch (this.infoUser.rol) {
            case "SECRETARIA":
                this.moduloCrearPaciente          = true;
                this.moduloHistoriaClinica        = true;
                this.moduloInforme                = true;
                this.moduloAgenda                 = true;
                this.moduloCitaCliente            = true;
                this.moduloInformeCita            = true;
                this.moduloTurno                  = true;

                /* Variables de configuracion del sistema */
                this.moduloParametros             = true;
                /* fin Variables de configuracion del sistema */

                break;
            case "MEDICO":
                this.moduloCrearPaciente   = true;
                this.turno          = true;
            break;
        }
    },
};
</script>
<style>
</style>
