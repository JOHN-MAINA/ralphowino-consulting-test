import Vue from 'vue';
import VueResource from 'vue-resource';

const EXPIRY_TIME = 60 * 60 * 24; // One day

Vue.use(VueResource);
export default {
    login: function (data) {
        let vm = Vue;
         Vue.http.post('/api/login', data).then(
             function (data) {
                 let storage = window.localStorage;
                 let user = {
                     name: data.body.success.name,
                     email: data.body.success.email,
                     identifier: data.body.success.id
                 };
                 storage.setItem('user', JSON.stringify(user));
                 storage.setItem('token', data.body.success.token);
                 storage.setItem('issuedTime', Date.now());

                 // Use route push
                 //window.location = '/friends';

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
                let user = {
                    name: data.body.success.name,
                    email: data.body.success.email,
                    identifier: data.body.success.id
                };
                storage.setItem('user', JSON.stringify(user));
                storage.setItem('token', data.body.success.token);
                storage.setItem('issuedTime', Date.now());

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

    },

    hasValidToken: function () {
        let isTokenValid = false;
        let jwt = localStorage.getItem("token");

        if(!jwt){
            // No access token
            this.clearLogin();
            return isTokenValid;
        }

        let accessToken = jwt.split('.');
        if(accessToken.length !== 3){
            // Not a valid jwt
            this.clearLogin();
            return isTokenValid;
        }

        // Decode jwt
        let data = JSON.parse(atob(accessToken[1]));
        const now = Date.now()/1000;
        console.log(now - (localStorage.getItem('issuedTime'))/1000);

        if(now - (localStorage.getItem('issuedTime'))/1000 > EXPIRY_TIME){
            // token was issued a day ago fetch a new one;
            this.clearLogin();
            return isTokenValid;
        }

        if((data.exp - now) < 1) {
            // token has expired
            this.clearLogin();
            return isTokenValid;
        }

        return true;
    },

    clearLogin: function () {
        localStorage.clear();
    }
}
