export const commons = {
    methods: {
        fnRemoveAccents(str) {
            return str.normalize("NFD").replace(/[\u0300-\u036f]/g, "");
        },
        /* METODOS PARA OBTENER INFORMACION DE CAMPOS PARAMETROS - INICIO */
        async fnBuscarParametro(parametrica){
            try {
                let response = await axios.get(`/consultorio-oftamologico/parametro/buscar?parametrica=${parametrica}`);
                return response.data.data;
            } catch (errores) {
                this.$swal({
                    icon: "error",
                    title: errores.response.data.message,
                    text : errores.response.data.errores[0]
                });
                return [];
            }
        }
        /* METODOS CAMPOS PARAMETROS FIN */
    },
};
