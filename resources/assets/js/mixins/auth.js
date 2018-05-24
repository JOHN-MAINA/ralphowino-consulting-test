import Vue from 'vue';
import VueResource from 'vue-resource';

Vue.use(VueResource);
export default {
    login: function (data) {
        let vm = Vue;
         Vue.http.post('/api/login', data).then(
             function (data) {
                 var storage = window.localStorage;
                 storage.setItem('token', data.body.success.token);

                 // Use route push
                 window.location = '/friends';

             },
             function (error){
                 console.log(error);
             }
         );
    },
    logout: function () {

    },
    register: function (data) {
        Vue.http.post('/api/register', data).then(
            function (data) {
                var storage = window.localStorage;
                storage.setItem('token', data.body.success.token);

                // Use route push
                window.location = '/friends';
            },
            function (error) {
                console.log(error);
            }
        )
    },
    requestPassResetToken: function () {

    },
    resetPass: function () {

    }
}