import Vue from 'vue';
import VueRouter from 'vue-router';

Vue.use(VueRouter);

/*auth*/
import login from './components/auth/login.vue'

/*Menu sajona*/

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

        { path: '*', component: errors }
    ]
})
export default router;
