<template>
    <v-app id="inspire">
        <v-container fluid fill-height style="background: #f8f8f8">

            <v-app-bar app class="elevation-0" style="background: #1000e1">
                <v-row>
                    <v-col cols="4">
                    </v-col>
                    <v-col cols="4" class="d-flex justify-center">
                        <div>
                            <v-icon size="50" dark> account_circle </v-icon>
                        </div>
                        <div style="align-self: center;" class="white--text">
                            <h2>LOGIN</h2>
                        </div>
                    </v-col>

                    <v-col cols="4" class="d-flex justify-end align-self-center">
                        <v-btn color="white" class="black--text">
                            {{ date }}<v-icon> date_range </v-icon>
                        </v-btn>
                    </v-col>
                </v-row>

            </v-app-bar>

            <v-layout align-center justify-center>
                <v-flex xs12 sm8 md4>
                    <v-card class="elevation-0" style="background: #f8f8f8">
                        <v-card-text class="mt-11">
                            <v-form>
                                <v-text-field
                                    prepend-icon="person"
                                    name="login"
                                    v-model="formData.email"
                                    label="Usuario"
                                    :error-messages="errors.email"
                                    type="text"
                                ></v-text-field>

                                <v-text-field
                                    id="password"
                                    prepend-icon="lock"
                                    name="password"
                                    v-model="formData.password"
                                    label="Contraseña"
                                    :error-messages="errors.password"
                                    type="password"
                                    @keyup.enter="login"
                                ></v-text-field>
                            </v-form>
                        </v-card-text>
                        <v-layout justify-end>
                            <v-card-actions class="mt-4">
                                <a class="pr-4" href="" style="text-decoration: none;color:#61d3e1;">He olvidado mi contraseña</a>
                                <v-spacer></v-spacer>
                                <v-btn
                                    color="success"
                                    class="text-none"
                                    v-on:click="login"
                                    >Ingresar
                                    <v-icon size="20" dark>
                                        done
                                    </v-icon></v-btn
                                >
                            </v-card-actions>
                        </v-layout>
                    </v-card>
                </v-flex>
                <loadingGeneral v-bind:overlayLoading="overlayLoading" />
            </v-layout>
        </v-container>
    </v-app>
</template>
<script>
import loadingGeneral from "../loadingGeneral/loadingGeneral.vue";
export default {
    components: { loadingGeneral },
    data() {
        return {
            formData: {
                email: "",
                password: "",
                device_name: "browser",
            },
            errors: {
                email: "",
                password: "",
            },

            date: "",
            overlayLoading: false,
        };
    },
    methods: {
        login() {
            this.overlayLoading = true;
            axios
                .post("ConsultorioOftamologicoLuisPuentes/login", this.formData)
                .then((response) => {
                    localStorage.setItem("token", response.data.access_token);
                    this.$router.push("/inicio/dashboard");
                    this.overlayLoading = false;
                    this.$swal("Bienvenido");
                })
                .catch((errors) => {
                    if (errors.response.status == 500) {
                        this.overlayLoading = false;
                        this.$swal({
                            icon: "error",
                            title: "Intentalo más tarde.",
                        });
                    } else {
                        this.overlayLoading = false;
                        this.errors = errors.response.data.errors;
                    }
                });
        },
    },
    mounted() {
        const fecha = new Date();
        const month = fecha.toLocaleString("es-CO", { month: "long" });

        this.date = `${fecha.getUTCDate()} ${month.substring(0,3)} ${fecha.getFullYear()} `;
    },
};
</script>
<style>
input {
    padding-left: 10px !important;
}
</style>
