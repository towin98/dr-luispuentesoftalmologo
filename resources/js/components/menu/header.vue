<template>
    <div>
        <div class="d-flex">
            <v-icon size="20" color="black">home</v-icon>
            <h4>Inicio</h4>
            <h4 v-if="proceso != 'inicio'"> / </h4>
            <h4 v-if="proceso != 'inicio'" class="text-capitalize">{{ proceso }}</h4>
            <v-spacer></v-spacer>
            <router-link  style="text-decoration: none;" v-if="pathPrevious != ''" :to="{ name: pathPrevious}" class="mr-3">
                Salir
            </router-link>
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
    props: ["proceso", "pathPrevious"],
};
</script>
