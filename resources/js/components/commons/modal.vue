<template>
    <v-dialog v-model="isOpenModal" persistent max-width="600px">
        <v-card>
            <v-card-title class="d-flex justify-center">
                <slot name="header"/>
            </v-card-title>
            <v-divider></v-divider>
            <v-card-text class="mt-5">
                <slot name="body"/>
            </v-card-text>
            <v-divider></v-divider>
            <v-card-actions>
                <v-spacer></v-spacer>
                <slot name="footer"/>
                <v-btn dark small @click="isOpenModal = false"
                    >Cancelar</v-btn
                >
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>
<script>
export default {
    props:{},
    watch: {
    },
    data() {
        return {
            isOpenModal: false,
        }
    },
    methods:{
        fnIsOpenModal(val){
            this.isOpenModal = val;
        },
    }
}
</script>
