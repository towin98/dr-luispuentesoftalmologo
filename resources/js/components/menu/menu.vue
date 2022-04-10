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
                                    <v-list-item :to="{ name: 'crear-cliente' }" v-if="crearCliente">
                                        <v-list-item-title>Crear Cliente</v-list-item-title>
                                    </v-list-item>
                                </v-list>
                            </v-menu>

                        </v-tab>
                        <v-tab
                            v-if="crearPaciente"
                            :to="{ name: 'crear-paciente' }"
                            class="white--text">
                            Crear Paciente
                        </v-tab>
                        <v-tab
                            v-if="historiaClinica"
                            :to="{ name: 'historia-clinica' }"
                            class="white--text">
                            Historia Clinica
                        </v-tab>
                        <v-tab
                            v-if="informe"
                            :to="{ name: 'informe' }"
                            class="white--text">
                            Informe
                        </v-tab>
                        <v-tab
                            v-if="agendar"
                            :to="{ name: 'agendar' }"
                            class="white--text">
                            Agendar
                        </v-tab>
                        <v-tab
                            v-if="turno"
                            :to="{ name: 'turno' }"
                            class="white--text">
                            Turno
                        </v-tab>
                    </v-tabs>
                </template>
            </v-app-bar>
            <v-main>
                <v-container>
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
            crearCliente    : false,
            crearPaciente   : false,
            historiaClinica : false,
            informe         : false,
            agendar         : false,
            turno           : false,
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
                this.crearCliente   = true;
                this.crearPaciente  = true;
                this.historiaClinica= true;
                this.informe        = true;
                this.agendar        = true;
                this.turno          = true;
                break;
            case "MEDICO":
                this.crearCliente   = true;
                this.turno          = true;
            break;
        }
    },
};
</script>
<style>
</style>
