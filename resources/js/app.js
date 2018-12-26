require('./bootstrap');
window.Vue = require('vue');

import App from './components/App';

import router from './router/index';

const app = new Vue({
    el: '#app',
    // App Component'ını ekliyoruz. Vue app'ine ekliyoruz.
    template: '<App/>',
    components: { App },
    router: router,
});
