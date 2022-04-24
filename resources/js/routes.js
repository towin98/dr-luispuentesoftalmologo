import Vue from 'vue';
import VueRouter from 'vue-router';

Vue.use(VueRouter);

/*auth*/
import login from './components/auth/login.vue'

/*Menu*/
import menu from './components/menu/menu.vue'
import inicio from './components/consultorio/inicio.vue'
import cliente from './components/consultorio/ingresar/cliente.vue'
import historiaClinica from './components/consultorio/historiaClinica/historiaClinica.vue'
import parametrosOcupacion from './components/consultorio/parametros/ocupacion.vue'
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
                    path: 'ingresar/cliente',
                    component: cliente,
                    name: 'cliente',
                },
                // {
                //     path: 'crear-paciente',
                //     component: inicio,
                //     name: 'crear-paciente',
                // },
                {
                    path: 'historia-clinica',
                    component: historiaClinica,
                    name: 'historia-clinica',
                },
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
                    path: 'configuracion-sistema/parametros/ocupacion',
                    component: parametrosOcupacion,
                    name: 'parametros-ocupacion',
                }
            ]
        },
        { path: '*', component: errors }
    ]
})
export default router;
