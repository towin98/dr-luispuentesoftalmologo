<template>
    <div>
        <loadingGeneral v-bind:overlayLoading="overlayLoading" />
        <h3 class="text-center mt-2">Roles</h3>
        <tableComponents
            v-bind:headers="headers"
            v-bind:permisos="permisos"
            v-bind:url_buscar="url_buscar">
        </tableComponents>

        <v-row justify="center">
            <v-dialog v-model="dialogParametro" persistent max-width="600px">
                <v-card>
                    <v-card-title>
                        <span class="text-h5">Rol --</span>
                    </v-card-title>
                    <v-card-text>
                        <v-container>
                            <v-row>
                            </v-row>
                        </v-container>
                    </v-card-text>
                    <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn
                            dark
                            color="darken-1"
                            @click="dialogParametro = false"
                        >
                            Cerrar
                        </v-btn>
                        <v-btn
                            color="success"
                            class="white--text"
                            @click="fnAccion()"
                            :disabled="!$can(['CREAR', 'EDITAR'])"
                        >
                            {{ cAccion }}
                        </v-btn>
                    </v-card-actions>
                </v-card>
            </v-dialog>
        </v-row>
    </div>
</template>
<script>
import tableComponents from "../commons/table.vue";
import loadingGeneral from "../loadingGeneral/loadingGeneral.vue";
export default {
    components:{
        tableComponents,
        loadingGeneral,
    },
    data() {
        return {
            overlayLoading : false,
            headers: [
                { text: "#", value: "id" },
                { text: "Nombre Rol", value: "name" },
                { text: "Fecha Modificado", value: "updated_at" },
                { text: "Editar", value: "editar", sortable: false },
            ],
            url_buscar: "/consultorio-oftamologico/config/roles-buscar",
            permisos : [],

            // Variables modal
            dialogParametro : false,
            cAccion     : 'GUARDAR'
        }
    },
    async created(){
        await this.$fnConsultaPermisosUsuario();
        this.permisos = await this.$fnPermisosUsuarios();
    },
}
</script>
