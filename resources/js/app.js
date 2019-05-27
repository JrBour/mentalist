import Vue from 'vue'
import VueRouter from 'vue-router'
import Vuetify from 'vuetify'
import 'vuetify/dist/vuetify.min.css'

Vue.use(VueRouter)
Vue.use(Vuetify)

import App from './App'
import ExampleComponent from './pages/ExampleComponent'
import Home from './pages/Home'

const router = new VueRouter({
    mode: 'history',
    routes: [
        {
            path: '/',
            name: 'home',
            component: Home
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
    components: { App },
    router,
});
