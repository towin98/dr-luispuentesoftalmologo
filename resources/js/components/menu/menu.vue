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
                        <v-list-item link>
                            <v-list-item-title>
                                <v-icon size="20"> people </v-icon> Cambio Usuario
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
                        <v-tab :to="{ name: 'inicio' }" class="white--text">Inicio</v-tab>
                        <v-tab class="white--text">

                            <v-menu offset-y rounded="lg">
                                <template v-slot:activator="{ on, attrs }">
                                    <v-btn
                                        v-bind="attrs"
                                        v-on="on"
                                        style="background: #1000e1"
                                        elevation="0"
                                        class="white--text">
                                        Ingresar
                                        <v-icon size="40" color="white"> arrow_drop_down </v-icon>
                                    </v-btn>
                                </template>

                                <v-list>
                                    <v-list-item :to="{ name: 'cliente' }" v-if="moduloCliente">
                                        <v-list-item-title>Crear Cliente</v-list-item-title>
                                    </v-list-item>
                                </v-list>
                            </v-menu>

                        </v-tab>
                        <!-- <v-tab
                            v-if="crearPaciente"
                            :to="{ name: 'paciente' }"
                            class="white--text">
                            Crear Paciente
                        </v-tab> -->
                        <v-tab
                            v-if="moduloHistoriaClinica"
                            :to="{ name: 'historia-clinica' }"
                            class="white--text">
                            Historia Clinica
                        </v-tab>
                        <v-tab
                            v-if="moduloInforme"
                            :to="{ name: 'informe' }"
                            class="white--text">
                            Informe
                        </v-tab>
                        <v-tab
                            v-if="moduloAgendar"
                            :to="{ name: 'agendar' }"
                            class="white--text">
                            Agendar
                        </v-tab>
                        <v-tab
                            v-if="moduloTurno"
                            :to="{ name: 'turno' }"
                            class="white--text">
                            Turno
                        </v-tab>
                        <v-tab class="white--text" v-if="moduloConfiguracionSistema">

                            <v-menu offset-y rounded="lg" close-on-click close-on-content-click content-class>
                                <template v-slot:activator="{ on, attrs }">

                                    <v-btn
                                        v-bind="attrs"
                                        v-on="on"
                                        style="background: #1000e1"
                                        elevation="0"
                                        class="white--text"
                                        title="Módulos para configuración del sistema">
                                        Configuración
                                        <v-icon size="40" color="white"> arrow_drop_down </v-icon>
                                    </v-btn>
                                </template>

                                <v-list>
                                    <v-list-item>
                                        <v-menu offset-x rounded="lg">
                                            <template v-slot:activator="{ on, attrs }">
                                                <v-btn
                                                    v-bind="attrs"
                                                    v-on="on"
                                                    small
                                                    elevation="0"
                                                    plain>
                                                    Parámetros
                                                    <v-icon size="40" color="dark"> arrow_right </v-icon>
                                                </v-btn>
                                            </template>
                                            <v-list outlined>
                                                <v-list-item :to="{ name: 'parametros-ocupacion' }" v-if="moduloParametroOcupacion">
                                                    <v-list-item-title>Ocupación</v-list-item-title>
                                                </v-list-item>
                                            </v-list>
                                        </v-menu>
                                    </v-list-item>
                                </v-list>

                            </v-menu>
                        </v-tab>
                    </v-tabs>
                </template>
            </v-app-bar>
            <v-main>
                <v-container fluid>
                    <router-view></router-view>
                </v-container>
            </v-main>
        </v-app>
    </div>
</template>
<script>
import loadingGeneral from "../loadingGeneral/loadingGeneral.vue";
import { rolesPermisos } from "../rolPermission/rolesPermisos.js";
export default {
    components: {
        loadingGeneral,
    },
    data() {
        return {
            token: localStorage.getItem("token_Historial_Clinico_Oftamologico"),
            date: "",

            // Variables permisos menus start
            moduloCliente    : false,
            // crearPaciente   : false,
            moduloHistoriaClinica         : false,
            moduloInforme                 : false,
            moduloAgendar                 : false,
            moduloTurno                   : false,

            /* Variables de configuracion del sistema */
            moduloConfiguracionSistema    : false,
            moduloParametroOcupacion      : false,
            /* fin Variables de configuracion del sistema */

            // Variables permisos menus end

            infoUser : {
                rol  : '',
                name : ''
            },
            intervalId: 0,

            titleProceso: "",
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
                this.moduloCliente           = true;
                // this.crearPaciente       = true;
                this.moduloHistoriaClinica        = true;
                this.moduloInforme                = true;
                this.moduloAgendar                = true;
                this.moduloTurno                  = true;

                /* Variables de configuracion del sistema */
                this.moduloConfiguracionSistema   = true;
                this.moduloParametroOcupacion     = true;
                /* fin Variables de configuracion del sistema */

                break;
            case "MEDICO":
                this.moduloCliente   = true;
                this.turno          = true;
            break;
        }
    },
};
</script>
<style>
</style>
