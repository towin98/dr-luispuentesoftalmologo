<template>
    <v-app id="inspire">
        <v-container fluid fill-height style="background: #f8f8f8">
            <headerAuth title="LOGIN"></headerAuth>

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
                                <router-link
                                    :to="{ name: 'recuperar-clave' }"
                                    class="pr-4 text-decoration-none text-subtitle-2"
                                    style="color:#61d3e1;">
                                    <span>He olvidado mi contraseña</span>
                                </router-link>
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
import headerAuth from "./headerAuth.vue";
export default {
    components: { loadingGeneral, headerAuth },
    data() {
        return {
            formData: {
                email: "",
                password: "",
                device_name: "browser",
                closeSesion: "NO"
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
        login(closeSesion = 'NO') {
            this.formData.closeSesion = closeSesion;
            this.overlayLoading = true;
            axios
                .post("/consultorio-oftalmologico/login", this.formData)
                .then((response) => {
                    localStorage.setItem("token_Historial_Clinico_Oftamologico", response.data.access_token);
                    this.$router.push("/consultorio/inicio");
                    this.overlayLoading = false;
                })
                .catch((errors) => {
                    this.overlayLoading = false;
                    if (errors.response == undefined) {
                        this.$swal({
                            icon: "error",
                            title: "Intentalo más tarde.",
                        });
                    }else if (errors.response.status == 423) {
                        this.$swal({
                            title: errors.response.data.message,
                            text: errors.response.data.errors,
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            cancelButtonText: 'N0',
                            confirmButtonText: 'SI'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    this.login('SI');
                                }
                            });
                    }else if(errors.response.status == 409 || errors.response.status == 422){
                        this.errors = errors.response.data.errors;
                    }else if (errors.response.status == 500) {
                        this.$swal({
                            icon: "error",
                            title: "Intentalo más tarde.",
                        });
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
