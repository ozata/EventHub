import Vue from 'vue';
import VueRouter from 'vue-router';

Vue.use(VueRouter);

import DashBoard from '../pages/DashBoard';
import EventList from '../pages/event/EventList';
import GameList from '../pages/game/GameList';

/**
 *  routes'taki name değerini Navbar.vue'da kullanarak dropdown list'te refer ediyoruz.
 * @type {*[]}
 */


const routes = [
    {
        path: '/',
        component: DashBoard,
        name: 'dashboard'
    },
    {
        path: '/events',
        component: EventList,
        name: 'event.index'
    },
    {
        path: '/games',
        component: GameList,
        name: 'game.index'
    }
];

export default new VueRouter({
    mode: 'history',
    routes
     //adam 'hash' kullandı.
})