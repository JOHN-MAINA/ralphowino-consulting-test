import VueRouter from 'vue-router';
import routes from './routes';
import App from './App.vue';
import Auth from './mixins/auth';
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

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

new Vue(Vue.util.extend({ router }, App)).$mount('#app');
