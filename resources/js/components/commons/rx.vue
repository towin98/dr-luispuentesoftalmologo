<template>
    <!-- START RX -->
    <v-row class="ml-2 mr-2 mb-4">
        <v-col sm="6" cols="12" class="pt-0">
            <table style="width: 100%; border-collapse: collapse;">
                <tr>
                    <td>
                        <v-subheader class="pr-1 pl-1">OD*</v-subheader>
                        <v-subheader class="pr-1 pl-1">OI*</v-subheader>
                    </td>
                    <td>
                        <h5 class="">RX</h5>
                        <v-text-field
                            v-model="form.rx_od"
                            :error-messages="erroresFormulaAnteojos.rx_od"
                            title="RX ojo derecho"
                            single-line
                            dense
                            solo
                            class="pr-1"
                        ></v-text-field>
                        <v-text-field
                            v-model="form.rx_oi"
                            :error-messages="erroresFormulaAnteojos.rx_oi"
                            title="RX ojo Izquierdo"
                            single-line
                            dense
                            solo
                            class="pr-1"
                        ></v-text-field>
                    </td>
                    <td>
                        <v-subheader class="pr-1 pl-1">Adicion</v-subheader>
                        <v-subheader class="pr-1 pl-1">DP</v-subheader>
                    </td>
                    <td>
                        <v-text-field
                            v-model="form.adicion"
                            :error-messages="erroresFormulaAnteojos.adicion"
                            title="Adición"
                            single-line
                            dense
                        ></v-text-field>
                        <v-text-field
                            v-model="form.dp"
                            :error-messages="erroresFormulaAnteojos.dp"
                            title="Distancia Pupilar"
                            single-line
                            dense
                        ></v-text-field>
                    </td>
                </tr>
            </table>
        </v-col>
        <v-col sm="6" cols="12">
            <v-textarea
                v-model="form.observacion"
                :error-messages="erroresFormulaAnteojos.observacion"
                rows="2"
                outlined
                label="Observación">
            </v-textarea>
        </v-col>
    </v-row>
    <!-- END RX -->

    <!-- <input v-model="valorInput" /> -->
</template>
<script>
export default {
    props: ['errors', 'limpiarFormRx', 'setFormRx'],
    watch: {
        form: {
            deep: true, //  Vue observará todos los cambios en las propiedades anidadas del objeto en lugar de solo observar el objeto en sí mismo.
            handler(formActualizado) {
                this.$emit('on:rx', formActualizado)
            }
        },
        errors: {
            deep: true, //  Vue observará todos los cambios en las propiedades anidadas del objeto en lugar de solo observar el objeto en sí mismo.
            handler(errorNew) {
                this.erroresFormulaAnteojos = errorNew
            }
        },
        limpiarFormRx: {
            deep: true, //  Vue observará todos los cambios en las propiedades anidadas del objeto en lugar de solo observar el objeto en sí mismo.
            handler(value) {
                this.fnLimpiarForm()
            }
        },
        setFormRx: {
            deep: true, //  Vue observará todos los cambios en las propiedades anidadas del objeto en lugar de solo observar el objeto en sí mismo.
            handler(form) {
                this.form = {
                    ...form
                }
            }
        },
    },
    data() {
        return {
            form: {
                rx_od : null,
                rx_oi : null,
                adicion : null,
                dp : null,
                observacion : null,
            },
            erroresFormulaAnteojos : ''
        };
    },
    methods: {
        fnLimpiarForm(){
            for (const key in this.form) {
                this.form[key] = null;
            }
        }
    }
};
</script>
<style></style>
