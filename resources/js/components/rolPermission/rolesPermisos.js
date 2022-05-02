export const rolesPermisos = {
    methods: {
        async informacionUsuario() {
            try {

                let response = await axios.get("/consultorio-oftamologico/informacion-usuario");
                let data = response.data.data;
                this.infoUser.rol  = data.roles[0].name; // Nombre de rol
                this.infoUser.name = data.name; // Nombre de usuario.

            } catch (errors) {
                if (errors.response != undefined) {
                    if (
                        errors.response.status == 401 ||
                        errors.response.status == 500
                    ) {
                        this.logout();
                        clearInterval(this.intervalId);
                        this.$swal("La Sesión ha caducado.", "", "info");
                    }
                }else{
                    this.logout();
                    clearInterval(this.intervalId);
                }
            }
        },
    },
};
