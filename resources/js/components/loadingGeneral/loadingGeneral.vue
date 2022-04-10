<template>
    <div>
        <div class="text-center">
            <v-overlay :value="overlayLoading" :z-index="999">
                <v-progress-circular
                    indeterminate
                    size="64"
                ></v-progress-circular>
            </v-overlay>
        </div>
    </div>
</template>
<script>
export default {
    name: "loadingGeneral",
    props:[
        "overlayLoading"
    ]
};
</script>
