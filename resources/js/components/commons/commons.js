export const commons = {
    methods: {
        fnRemoveAccents(str) {
            return str.normalize("NFD").replace(/[\u0300-\u036f]/g, "");
        },
        async fnBuscarParametro(parametrica){
            try {
                let response = await axios.get(`/consultorio-oftamologico/parametro/buscar?parametrica=${parametrica}`);
                return response.data.data;
            } catch (errores) {
                // this.$swal({
                //     icon: "error",
                //     title: errores.response.data.message,
                //     text : errores.response.data.errores[0]
                // });
                return [];
            }
        },
        fnResponseError(errores){
            if (errores.response != undefined) {
                if (errores.response.status == 500 ||
                    errores.response.status == 403 ||
                    errores.response.status == 409 ||
                    errores.response.status == 405 ||
                    errores.response.status == 404)
                {
                    let mensaje = "El sistema a generado una validación.";
                    if (errores.response.data.message != undefined) {
                        mensaje = errores.response.data.message;
                    }
                    this.$swal({
                        icon: 'error',
                        title: `${mensaje}`,
                        text: `${errores.response.data.errors}`,
                    })
                    return '';
                }else{
                    if (errores.response.status == 422) {
                        return errores.response.data.errors;
                    }
                }

            }
        }
    },
};
