<template>
    <v-app>
        <div class="page_404">
            <div class="container">
                <v-row>
                    <v-col>
                        <div class="text-center">
                            <div class="four_zero_four_bg">
                                <h1 class="text-center">404</h1>
                            </div>

                            <div class="contant_box_404">
                                <h3 class="h2">Parece que estás perdido</h3>

                                <p>La pagina que buscas no esta disponible!</p>

                                <a href="/" class="link_404">Ir al Inicio</a>
                            </div>
                        </div>
                    </v-col>
                </v-row>
            </div>
        </div>
    </v-app>
</template>
<style scoped>
.page_404 {
    padding: 40px 0;
    background: #fff;
    font-family: "Arvo", serif;
}

.page_404 img {
    width: 100%;
}

.four_zero_four_bg {
    background-image: url(/img/sistema/dribbble_1.gif);
    height: 400px;
    background-position: center;
}

.four_zero_four_bg h1 {
    font-size: 80px;
}

.four_zero_four_bg h3 {
    font-size: 80px;
}

.link_404 {
    color: #fff !important;
    padding: 10px 20px;
    background: #39ac31;
    margin: 20px 0;
    display: inline-block;
}
.contant_box_404 {
    margin-top: -50px;
}
</style>
