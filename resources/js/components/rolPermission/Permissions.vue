<script>
let arrPermisos = [];
export default {
    methods: {
        async informacionUsuario() {
            try {

                let response = await axios.get("/consultorio-oftamologico/informacion-usuario");
                let data = response.data.data;
                this.infoUser.rol  = data.roles[0].name; // Nombre de rol
                this.infoUser.name = data.name; // Nombre de usuario.

            } catch (errors) {
                console.log(errors);
                if (errors.response != undefined) {
                    if (
                        errors.response.status == 401 ||
                        errors.response.status == 500
                    ) {
                        this.logout();
                        this.$swal("La Sesión ha caducado.", "", "info");
                    }
                }else{
                    this.logout();
                }
            }
        },

        /**
         * Método que verifica si el usuario tiene al menos un permiso pasado como parametro.
         *
         * @param {Array} permissionName Array de permisos.
         * @returns {Boolean} true si tiene permiso o false de lo contrario.
         */
        $can(permissionName = []) {
            let permissionsEncontrado = false;
            permissionName.forEach(permiso => {
                if (arrPermisos.indexOf(permiso) !== -1) {
                    permissionsEncontrado = true;
                }
            });
            return permissionsEncontrado;
        },
        async $fnPermisosUsuarios(){
            return arrPermisos;
        },
        /**
         * Método que consulta permisos del usuario autenticado.
         */
        async $fnConsultaPermisosUsuario(){
            try {
                let response = await axios.get("/consultorio-oftamologico/permisos-usuario");
                arrPermisos = response.data.data;
            } catch (error) {
                // console.log(error);
            }
        }
    }
};
</script>
