export const commons = {
    methods: {
        fnRemoveAccents(str) {
            return str.normalize("NFD").replace(/[\u0300-\u036f]/g, "");
        },
        async fnBuscarParametro(parametrica){
            try {
                let response = await axios.get(`/consultorio-oftalmologico/parametro/buscar?parametrica=${parametrica}`);
                let data = response.data.data;
                for (let i = 0; i < data.length; i++) {
                    if (data[i].estado != "ACTIVO") {
                        data[i].disabled = true;
                    }
                }
                return data;
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
                if (errores.response.status == 401) {
                    return '';
                }
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
        },
    },
};
