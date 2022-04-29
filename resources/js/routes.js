import Vue from 'vue';
import VueRouter from 'vue-router';

Vue.use(VueRouter);

/*auth*/
import login from './components/auth/login.vue'

/*Menu*/
import menu from './components/menu/menu.vue'
import inicio from './components/consultorio/inicio.vue'
import crearPaciente from './components/consultorio/ingresar/crearPaciente.vue'
import busquedaHistoriaClinica from './components/consultorio/historiaClinica/busquedaHistoriaClinica.vue'
import evolucion from './components/consultorio/historiaClinica/evolucion.vue'
import parametrosEps from './components/consultorio/parametros/eps.vue'
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
                    path: 'historia-clinica/evolucion/:numero_documento',
                    component: evolucion,
                    name: 'historia-clinica/evolucion',
                },
                // Historia clinica FIN
                {
                    path: 'informe',
                    component: inicio,
                    name: 'informe',
                },
                {
                    path: 'agendar',
                    component: inicio,
                    name: 'agendar',
                },
                {
                    path: 'turno',
                    component: inicio,
                    name: 'turno',
                },
                {
                    path: 'configuracion-sistema/parametros/eps-prepagada',
                    component: parametrosEps,
                    name: 'eps',
                }
            ]
        },
        { path: '*', component: errors }
    ]
})
export default router;
