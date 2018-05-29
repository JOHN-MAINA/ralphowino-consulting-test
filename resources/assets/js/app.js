import VueRouter from 'vue-router';
import routes from './routes';
import App from './App.vue';
import Auth from './mixins/auth';
import store from './store/store';
import Vue from 'vue';
let VueResource = require('vue-resource');

require('./bootstrap');

window.Vue = Vue;
Vue.use(VueResource);
Vue.use(VueRouter);

const router = new VueRouter({
   // mode: 'history',
    routes
});

// Check if user is authenticated
router.beforeResolve((to, from, next) => {
    if (to.meta.requiresAuth && !Auth.hasValidToken()) {
        next({name: 'Login'});
    }
    next();
});

let vm = new Vue({
    mixins: [Auth],
    store: store,
    el: '#app',
    'router': router,
    render: h => h(App)
});

export default {
    vm
};
