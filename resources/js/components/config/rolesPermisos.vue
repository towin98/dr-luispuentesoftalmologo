<template>
    <div>
        <loadingGeneral v-bind:overlayLoading="overlayLoading" />
        <h3 class="text-center mt-2">Roles</h3>
        <tableComponents
            v-bind:headers="headers"
            v-bind:permisos="permisos"
            v-bind:url_buscar="url_buscar"
            @fnRolAccion="fnRolAccion"
            >
        </tableComponents>

        <v-row justify="center">
            <v-dialog v-model="dialogRolPermisos" persistent max-width="600px">
                <v-card>
                    <v-card-title>
                        <span class="text-h5">ROL {{ textRol }}</span>
                    </v-card-title>
                    <v-card-text>
                            <v-container>
                                <h3>Permisos</h3>
                                <ul style="list-style-type: decimal;">
                                    <li v-for="(permiso, i) in itemlistaPermisos" :key="i">
                                        <v-checkbox
                                            v-model="form[permiso.name]"
                                            :label="permiso.name"
                                            :value="permiso.id"
                                            dense
                                            :disabled="permiso.disabled"
                                        ></v-checkbox>
                                    </li>
                                </ul>
                            </v-container>
                    </v-card-text>
                    <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn
                            dark
                            color="darken-1"
                            @click="dialogRolPermisos = false"
                        >
                            Cerrar
                        </v-btn>
                        <v-btn
                            color="success"
                            class="white--text"
                            @click="fnGuardar()"
                            :disabled="!$can(['EDITAR'])"
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
                { text: "Ver", value: "ver", sortable: false },
            ],
            url_buscar: "/consultorio-oftamologico/rol-permisos/roles-buscar",
            permisos : [],

            // Variables modal
            dialogRolPermisos : false,
            cAccion           : 'GUARDAR',
            textRol           : '',
            listaPermisos     : [],
            itemlistaPermisos : [],//mostrar
            itemsPermisosRol  : [],
            form : {
                idRol : '' // Aqui se guarda id del rol para asignarle permisos.
            }
        }
    },
    async created(){
        await this.$fnConsultaPermisosUsuario();
        this.permisos = await this.$fnPermisosUsuarios();
    },
    methods: {
        fnRolAccion(accion, data){
            this.dialogRolPermisos = true;
            this.textRol = data.data.name;
            this.form.idRol = data.data.id;

            //Limpiando arrays para construir checkbox
            this.listaPermisos     = [];
            this.itemlistaPermisos = [];
            this.itemsPermisosRol  = [];

            switch (accion) {
                case 'VER':
                this.fnConsultarPermisos(data, accion);
                break;
                case 'EDITAR':
                    this.fnConsultarPermisos(data, '');
                break;
                case 'ELIMINAR':
                break;
            }
        },
        fnConsultarPermisos(data, accion){
            this.overlayLoading = true;
            axios
                .get(`/consultorio-oftamologico/rol-permisos/listar-permisos`)
                .then((response) => {
                    this.listaPermisos = response.data.data;
                    this.fnConsultarPermisosRol(data.data.id, accion);
                })
                .catch((errores) => {
                    this.overlayLoading = false;
                    this.dialogRolPermisos = false;
                    this.fnResponseError(errores);
                });
        },
        fnConsultarPermisosRol(id, accion){
            this.overlayLoading = true;
            axios
                .get(`/consultorio-oftamologico/rol-permisos/listar-permisos-rol/${id}`)
                .then((response) => {
                    this.itemsPermisosRol = response.data.data;
                    for (let i = 0; i < this.listaPermisos.length; i++) {
                        let value = "";
                        this.listaPermisos[i].disabled = (accion === "VER" ? true : false);
                        for (let PR = 0; PR < this.itemsPermisosRol.length; PR++) {
                            // Se busca permisos del rol para marcar checkbox
                            if (this.itemsPermisosRol[PR] == this.listaPermisos[i].name) {
                                value = this.listaPermisos[i].id;
                                break;
                            }
                        }
                        let key   = this.listaPermisos[i].name; // Obtenemos nombre de permiso para crear form
                        this.form[key] = value;
                    }
                    this.itemlistaPermisos = this.listaPermisos;
                    this.overlayLoading = false;
                })
                .catch((errores) => {
                    this.overlayLoading = false;
                    this.dialogRolPermisos = false;
                    this.fnResponseError(errores);
                });
        },
        fnGuardar(){
            this.overlayLoading = true;
            axios
                .post(`/consultorio-oftamologico/rol-permisos/guardar`, this.form)
                .then((response) => {
                    this.dialogRolPermisos = false;
                    this.$swal(
                        response.data.message,
                        '',
                        'success'
                    );
                    this.overlayLoading = false;
                })
                .catch((errores) => {
                    this.overlayLoading = false;
                    this.dialogRolPermisos = false;
                    this.fnResponseError(errores);
                });
        }
    }
}
</script>
