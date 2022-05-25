<template>
    <v-app>
        <loadingGeneral v-bind:overlayLoading="overlayLoading" />
        <v-container fluid fill-height style="background: #f8f8f8">

            <headerAuth title="Recuperar Password"></headerAuth>

            <v-layout align-center justify-center>
                <v-flex xs12 sm8 md4>
                    <v-card class="elevation-0" style="background: #f8f8f8">
                        <v-toolbar
                            class="d-flex justify-center rounded-0 elevation-0"
                            style="background: #f8f8f8"
                        >
                            <v-toolbar-title class="dark--text">
                                    <h3>CONSULTORIO OFTALMOLÓGICO</h3>
                            </v-toolbar-title>
                        </v-toolbar>
                        <v-card-text class="mt-11">
                            <v-form>
                                <v-text-field
                                    prepend-icon="email"
                                    name="login"
                                    v-model="form.email"
                                    label="Email"
                                    :error-messages="errors.email"
                                    type="text"
                                ></v-text-field>
                            </v-form>
                        </v-card-text>
                        <v-layout justify-center>
                            <v-card-actions class="mt-2">
                                <v-spacer></v-spacer>
                                <v-btn
                                    :link="true"
                                    color="primary"
                                    class="text-none"
                                    v-on:click="fnRecuperarPass">
                                    RECUPERAR CONTRASEÑA
                                </v-btn>
                            </v-card-actions>
                        </v-layout>
                        <v-layout justify-center>
                            <v-card-actions>
                                <v-spacer></v-spacer>
                                <router-link
                                    :to="{ name: 'login' }"
                                    class="pr-3 text-decoration-none text-subtitle-2 dark--text">
                                    <span>Regresar al login</span>
                                </router-link>
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
            form : {
                email : ''
            },
            errors : {},
            overlayLoading: false,
            date: "",
        }
    },
    methods:{
        fnRecuperarPass(){
            this.overlayLoading = true;
            axios
                .post("/consultorio-oftamologico/password/email", this.form)
                .then((response) => {
                    this.overlayLoading = false;
                    this.$swal(
                        'Datos de Acceso',
                        response.data.message,
                        'success'
                    );
                    this.$router.push("/");
                })
                .catch((errors) => {
                    this.overlayLoading = false;
                    if (errors.response.status == 500) {
                        this.$swal({
                            icon: 'error',
                            title: `Error inesperado al recuperar clave`,
                            text: `${errors.response.data.errors}`,
                        });
                    }else if(errors.response.status == 401){ // Ojo el error 401 es de que no existe el email.
                        this.$swal({
                            icon: 'error',
                            title: ``,
                            text: `${errors.response.data.errors}`,
                        });
                        this.$router.push("/");
                    }else{
                        this.errors = errors.response.data.errors;
                    }
                });
        }
    },
    mounted() {
        const fecha = new Date();
        const month = fecha.toLocaleString("es-CO", { month: "long" });

        this.date = `${fecha.getUTCDate()} ${month.substring(0,3)} ${fecha.getFullYear()} `;
    },
}
</script>
