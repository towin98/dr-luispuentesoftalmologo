<template>
    <div>
        <div class="d-flex">
            <v-icon size="20" color="black">home</v-icon>
            <h4>Inicio</h4>
            <h4 v-if="local_proceso != 'inicio'"> / </h4>
            <h4 v-if="local_proceso != 'inicio'" class="text-capitalize">{{ local_proceso }}</h4>
        </div>
        <v-progress-linear
            color="grey"
            rounded
            value="100"
        ></v-progress-linear>
    </div>
</template>
<script>
export default {
    data() {
        return {
            local_proceso : this.proceso,
        }
    },
    props: ["proceso"],
    watch:{
        proceso() {
            this.local_proceso = this.proceso;
        }
    },
    methods:{
    },
    created(){
        // Obteniendo nombre de la ruta.
        if (this.$route.name) {
            this.local_proceso = this.$route.name.replace("-", " ");
        }
    }
};
</script>
