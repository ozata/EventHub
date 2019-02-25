import Vue from 'vue';
import VueRouter from 'vue-router';

Vue.use(VueRouter);

import EventList from '../pages/event/EventList';
import GameList from '../pages/game/GameList';


import Home from '../pages/Home'
import Register from '../pages/Register'
import Login from '../pages/Login'
import Dashboard from '../pages/user/Dashboard'
import AdminDashboard from '../pages/admin/Dashboard'



/**
 *  routes'taki name değerini Navbar.vue'da kullanarak dropdown list'te refer ediyoruz.
 * @type {*[]}
 */


const routes = [
    {
        path: '/',
        name: 'home',
        component: Home,
        meta: {
            auth: undefined
        }
    },
    {
        path: '/register',
        name: 'register',
        component: Register,
        meta: {
            auth: false
        }
    },
    {
        path: '/login',
        name: 'login',
        component: Login,
        meta: {
            auth: false
        }
    },
    // USER ROUTES
    {
        path: '/dashboard',
        name: 'dashboard',
        component: Dashboard,
        meta: {
            auth: true
        }
    },
    {
        path: '/events',
        component: EventList,
        name: 'event.index',
        meta: {
            auth: true
        }
    },
    {
        path: '/games',
        component: GameList,
        name: 'game.index',
        meta: {
            auth: true
        }
    },
    // ADMIN ROUTES
    {
        path: '/admin',
        name: 'admin.dashboard',
        component: AdminDashboard,
        meta: {
            auth: {roles: 2, redirect: {name: 'login'}, forbiddenRedirect: '/403'}
        }
    },

];

export default new VueRouter({
    mode: 'history', // Another mode is hash
    routes
})