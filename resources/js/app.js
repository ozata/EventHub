require('./bootstrap');
window.Vue = require('vue');

import App from './components/App';

import router from './router/index';
import 'es6-promise/auto'
import axios from 'axios'
import './bootstrap'
import Vue from 'vue'
import VueAuth from '@websanova/vue-auth'
import VueAxios from 'vue-axios'
import VueRouter from 'vue-router'
import Index from './Index'
import auth from './auth'

// Set Vue router
Vue.router = router
Vue.use(VueRouter)


// Set Vue authentication
Vue.use(VueAxios, axios)
axios.defaults.baseURL = 'http://127.0.0.1:8000/api'
Vue.use(VueAuth, auth)

Vue.component('index', Index);

const app = new Vue({
    el: '#app',
    // App Component'ını ekliyoruz. Vue app'ine ekliyoruz.
    template: '<Index/>',
    components: { App, Index },
    router: router,
});
