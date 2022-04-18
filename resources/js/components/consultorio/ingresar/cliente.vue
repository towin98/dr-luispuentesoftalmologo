<template>
    <div>
        <loadingGeneral v-bind:overlayLoading="overlayLoading"/>
        <v-checkbox
            v-model="tipoPersona"
            label="Persona Juridica"
            color="indigo"
            value="SI"
        ></v-checkbox>
        <formPersonaNatural v-if="tipoPersona != 'SI'"/>
        <formPersonaJuridica v-if="tipoPersona == 'SI'"/>
    </div>
</template>
<script>
import formPersonaNatural  from "./formPersonaNatural.vue";
import formPersonaJuridica  from "./formPersonaJuridica.vue";
import loadingGeneral from "../../loadingGeneral/loadingGeneral.vue";
export default {
    components : {
        formPersonaNatural,formPersonaJuridica,loadingGeneral
    },
    data() {
        return {
            tipoPersona         : 'SI',
            overlayLoading      : false,
        }
    },
    methods :{
    },

}
</script>
