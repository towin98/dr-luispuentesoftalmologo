import Vue from 'vue';
import VueRouter from 'vue-router';

Vue.use(VueRouter);

/*auth*/
import login from './components/auth/login.vue'
import recuperarPass from './components/auth/recuperarPass.vue'

/*Menu*/
import menu from './components/menu/menu.vue'
import inicio from './components/consultorio/inicio.vue'
import crearPaciente from './components/consultorio/ingresar/crearPaciente.vue'
import busquedaHistoriaClinica from './components/consultorio/historiaClinica/busquedaHistoriaClinica.vue'
import cargarArchivo from './components/consultorio/historiaClinica/cargarArchivo.vue'
import motivoConsulta from './components/consultorio/historiaClinica/motivoConsulta.vue'
import formulaAnteojos from './components/consultorio/historiaClinica/formulaAnteojos.vue'
import antecedentes from './components/consultorio/historiaClinica/antecedentes.vue'
import citaCliente from './components/consultorio/agenda/citaCliente.vue'
import informeCita from './components/consultorio/agenda/informeCita.vue'

import parametrosEps from './components/config/parametros/eps.vue' // Medicina Prepagada.
import cambioClave from './components/config/cambioClave.vue'
/*Menu end*/

import errors from './components/errors/404.vue'

const router = new VueRouter({
    mode: 'history',
    routes: [
        {
            path: '/',
            component: login,
            name: 'login',
            meta: {guest: true}
        },
        {
            path: '/auth/recuperar-clave',
            component: recuperarPass,
            name: 'recuperar-clave',
            meta: {guest: true}
        },
        {
            path: '/consultorio',
            component: menu,
            meta: {requiresAuth: true},
            children:[

                {
                    path: 'inicio',
                    component: inicio,
                    name: 'inicio',
                },
                {
                    path: 'ingresar/crear-paciente',
                    component: crearPaciente,
                    name: 'crear-paciente',
                },
                // Historia clinica INICIO
                {
                    path: 'historia-clinica',
                    component: busquedaHistoriaClinica,
                    name: 'historia-clinica',
                },
                {
                    path: 'historia-clinica/motivo-consulta/:numero_documento',
                    component: motivoConsulta,
                    name: 'historia-clinica/motivo-consulta',
                },
                {
                    path: 'historia-clinica/formula-anteojos/:numero_documento',
                    component: formulaAnteojos,
                    name: 'historia-clinica/formula-anteojos',
                },
                {
                    path: 'historia-clinica/antecedentes/:numero_documento',
                    component: antecedentes,
                    name: 'historia-clinica/antecedentes',
                },
                {
                    path: 'historia-clinica/cargar-archivo/:numero_documento',
                    component: cargarArchivo,
                    name: 'historia-clinica/cargar-archivo',
                },
                // Historia clinica FIN

                // Agenda
                {
                    path: 'agenda/cita-cliente',
                    component: citaCliente,
                    name: 'agenda/cita-cliente',
                },
                {
                    path: 'agenda/informe-cita',
                    component: informeCita,
                    name: 'agenda/informe-cita',
                },
                // Agenda

            ],
        },
        {
            path: '/configuracion-sistema',
            component: menu,
            meta: {requiresAuth: true},
            children:[
                {
                    path: 'parametros/medicina-prepagada',
                    component: parametrosEps,
                    name: 'medicina-prepagada',
                },
                {
                    path: 'cambio-clave',
                    component: cambioClave,
                    name: 'cambio-clave',
                }
            ],
        },
        { path: '*', component: errors }
    ]
})
export default router;
