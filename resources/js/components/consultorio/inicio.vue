<template>
    <div>
        <v-card class="mx-auto mt-2" max-width="344" outlined color="dark">
            <v-card-title>
                <span class="text-h6 font-weight-bold">CITAS AGENDADAS PARA HOY</span>
            </v-card-title>
            <v-card-subtitle class="text-h5 text-center">{{ cantidadCitasHoy }}</v-card-subtitle>
        </v-card>
    </div>
</template>
<script>
import loadingGeneral from "../loadingGeneral/loadingGeneral.vue";
export default {
    components: {
        loadingGeneral,
    },
    data() {
        return {
            cantidadCitasHoy: 0,
            overlayLoading : false
        };
    },
    methods: {
        fnBuscarCitas() {
            let date = new Date();

            let day = date.getDate();
            let month = date.getMonth() + 1;
            let year = date.getFullYear();

            if(month < 10) month = `0${month}`;

            if(day < 10) day = `0${day}`;

            const hoy = `${year}-${month}-${day}`;

            const data = {
                tipo_informe_cita: "DIA",
                fecha_reporte: hoy,
            };

            axios
                .post(
                    `/consultorio-oftamologico/agenda/informe-cita/listar`,
                    data
                )
                .then((response) => {
                    this.cantidadCitasHoy = response.data.data.length;
                })
                .catch((errores) => {
                    this.fnResponseError(errores);
                });
        }
    },
    created(){
        this.fnBuscarCitas();
    }
};
</script>
