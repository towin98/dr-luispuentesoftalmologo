<template>
    <!-- Start Modal Orden Médica -->
    <v-dialog v-model="modalImprimirOrdenMedica" persistent max-width="600px">
        <v-card>
            <v-toolbar color="grey lighten-2"
                >Eliga la dirección a incluir en la Orden Médica</v-toolbar
            >
            <v-card-text class="mt-3">
                <v-btn
                    dark
                    small
                    color="success"
                    v-on:click="fnDescargarPdfHistoriaClinica('orden_medica', 'centro_oftamologico')"
                    >Centro Oftalmológico</v-btn
                >
                <v-btn
                    dark
                    small
                    color="success"
                    v-on:click="fnDescargarPdfHistoriaClinica('orden_medica', 'oftamolaser_sa')"
                    >Oftamolaser SA</v-btn
                >
                <v-btn
                    dark
                    small
                    color="red darken-4"
                    v-on:click="fnDescargarPdfHistoriaClinica('orden_medica')"
                    >Vacío (Sin datos)</v-btn
                >
            </v-card-text>
            <v-divider></v-divider>
            <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn dark small @click="modalImprimirOrdenMedica = false"
                    >Cancelar</v-btn
                >
            </v-card-actions>
        </v-card>
    </v-dialog>
    <!-- end Modal Orden Médica -->
</template>
<script>
export default {
    name: "modalOrdenMedicaPdf",
    data() {
        return {
            modalImprimirOrdenMedica: false,
        }
    },
    methods : {
        fnAbrirModalImprimirOrdenMedicaLocal(val){
            this.modalImprimirOrdenMedica = val;
        },
        fnDescargarPdfHistoriaClinica(reporte = '', info_centro = ''){
            this.$emit('fnDescargarPdf', reporte, info_centro);
        }
    }
}
</script>
