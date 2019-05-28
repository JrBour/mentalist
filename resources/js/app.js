import Vue from 'vue'
import VueRouter from 'vue-router'
import Vuetify from 'vuetify'
import 'vuetify/dist/vuetify.min.css'

Vue.use(VueRouter)
Vue.use(Vuetify)

import App from './App'
import { store } from './store/store'
import ExampleComponent from './pages/ExampleComponent'
import Home from './pages/Home'
import Login from './pages/Login'
import Register from './pages/Register'

const router = new VueRouter({
    mode: 'history',
    routes: [
        {
            path: '/',
            name: 'home',
            component: Home
        },
        {
            path: '/login',
            name: 'login',
            component: Login
        },
        {
            path: '/register',
            name: 'register',
            component: Register
        },
        {
            path: '/hello',
            name: 'hello',
            component: ExampleComponent,
        },
    ],
});

const app = new Vue({
    el: '#app',
    store,
    components: { App },
    router,
});
