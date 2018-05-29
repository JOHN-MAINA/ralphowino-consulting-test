// Configure vue resource to send access token with all requests


import Vue from 'vue'
import VueResource from 'vue-resource';

Vue.use(VueResource);

Vue.http.headers.common['Accept'] = 'application/json';
Vue.http.headers.common['Authorization'] = 'Bearer ' + localStorage.getItem('token');
const METHOD_GET = 'get';
const METHOD_POST = 'post';
const METHOD_PUT = 'put';
export default {

    doRequest: function (method, url) {
        return new Promise((resolve, reject) => {

            let onSuccess= (data) => {
                resolve(data.body);
            };

            let onFail = function (data) {
                reject(data)
            };

            switch (method) {
                case METHOD_GET:
                    Vue.http.get(url).then(onSuccess, onFail);
                    break;
                case METHOD_PUT:
                    Vue.http.put(url, JSON.stringify(data)).then(onSuccess, onFail);
                    break;
                default:
                    const dataStr = JSON.stringify(data);
                    Vue.http.post(url, dataStr).then(onSuccess, onFail);
            }

        })
    },



    post: function (url, data) {
        
    },
    
    get: function (url) {
        return this.doRequest(METHOD_GET, '/api/' + url);
    }
}