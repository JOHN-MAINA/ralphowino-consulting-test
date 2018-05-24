import Vue from 'vue';
var VueResource = require('vue-resource');

Vue.use(VueResource);

Vue.http.options.root = '/root';
Vue.http.headers.common['Authorization'] = 'Basic YXBpOnBhc3N3b3Jk';

export default {

    post: function (url, data) {
        
    },
    
    get: function (url) {
        
    }
}