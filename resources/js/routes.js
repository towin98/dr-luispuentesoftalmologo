import Vue from 'vue';
import VueRouter from 'vue-router';

Vue.use(VueRouter);

/*auth*/
import login from './components/auth/login.vue'

/*Menu*/
import menu from './components/menu/menu.vue'
import inicio from './components/consultorio/inicio.vue'
import crear_cliente from './components/consultorio/ingresar/crear-cliente.vue'
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
                    path: 'ingresar/crear-cliente',
                    component: crear_cliente,
                    name: 'crear-cliente',
                },
                {
                    path: 'crear-paciente',
                    component: inicio,
                    name: 'crear-paciente',
                },
                {
                    path: 'historia-clinica',
                    component: inicio,
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
            ]
        },
        { path: '*', component: errors }
    ]
})
export default router;
