<template>
    <!-- En este DIV ira la firma del doctor, solo se permite visualizar al imprimir formulario. -->
    <div style="padding-right: 20px">
        <div style="display: flex; flex-direction: column; align-items: end">
            <div style="margin-right: 45px">
                <v-img
                    src="/img/sistema/firma_medico.png"
                    class="width-height-img-firma"
                    alt="Firma"
                ></v-img>
            </div>
            <div>
                <p class="font-size-firma">
                    DR. LUIS AUGUSTO PUENTES MILLAN <br />
                    CC. 19.143.147 Bogotá D.C<br />
                    Registro No. 8127/76
                </p>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    name: "firma-formulario",
};
</script>
<style>
.width-height-img-firma {
    width: 0px;
    height: 0px;
}
.font-size-firma {
    font-size: 0px;
}
@media print {
    .width-height-img-firma {
        width: 170px;
        height: auto;
    }
    .font-size-firma {
        font-size: 13px;
    }
}
</style>
