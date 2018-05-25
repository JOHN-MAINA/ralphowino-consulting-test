import VueRouter from 'vue-router';
import routes from './routes';
import App from './App.vue';
import Auth from './mixins/auth';
import store from './store/store';
import Vue from 'vue';
var VueResource = require('vue-resource');

require('./bootstrap');

window.Vue = Vue;
Vue.use(VueResource);
Vue.use(VueRouter);

const router = new VueRouter({
   // mode: 'history',
    routes
});

// Check if user is authenticated
router.beforeEach((to, from, next) => {
    if (to.meta.requiresAuth && !Auth.hasValidToken()) {
        next({name: 'Login'});
    }
    next();
});

let vm = new Vue({
    store: store,
    el: '#app',
    router,
    render: h => h(App)
});

//new Vue(Vue.util.extend({ router }, App)).$mount('#app');
