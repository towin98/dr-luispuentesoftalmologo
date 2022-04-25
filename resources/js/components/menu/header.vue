<template>
    <div>
        <div class="d-flex">
            <v-icon size="20" color="black">home</v-icon>
            <h4>Inicio</h4>
            <h4 v-if="proceso != 'inicio'"> / </h4>
            <h4 v-if="proceso != 'inicio'" class="text-capitalize">{{ proceso }}</h4>
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
    props: ["proceso"],
};
</script>
