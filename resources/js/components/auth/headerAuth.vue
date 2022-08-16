<template>
    <v-app-bar app class="elevation-0" style="background: #1000e1" :short="true" height="70">
        <v-row>
            <v-col cols="0" sm="4" class="pt-0 pb-0"> </v-col>
            <v-col cols="6" sm="4" class="d-flex justify-center pt-0 pb-0">
                <div>
                    <v-icon size="50" dark> account_circle </v-icon>
                </div>
                <div class="white--text d-flex align-center">
                    <h3>{{ title }}</h3>
                </div>
            </v-col>

            <v-col cols="6" sm="4" class="d-flex justify-end align-self-center pt-0 pb-0">
                <v-btn color="white" class="black--text">
                    {{ date }}<v-icon> date_range </v-icon>
                </v-btn>
            </v-col>
        </v-row>
    </v-app-bar>
</template>
<script>
export default {
    props:['title'],
    data() {
        return {
            date: "",
        };
    },
    mounted() {
        const fecha = new Date();
        const month = fecha.toLocaleString("es-CO", { month: "long" });

        this.date = `${fecha.getUTCDate()} ${month.substring(0,3)} ${fecha.getFullYear()} `;
    },
};
</script>
