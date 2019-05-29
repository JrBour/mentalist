import Vue from 'vue'
import VueRouter from 'vue-router'
import Vuetify from 'vuetify'
import 'vuetify/dist/vuetify.min.css'

Vue.use(VueRouter)
Vue.use(Vuetify)

import App from './App';
import axios from 'axios';
import { store } from './store/store';
import Home from './pages/Home';
import Login from './pages/Login';
import Register from './pages/Register';
import Profile from './pages/Profile/Profile';
import ProfileEdit from './pages/Profile/ProfileEdit';
import Articles from './pages/Articles'

axios.defaults.baseURL = 'http://localhost:80/api/';


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
            path: '/profile',
            name: 'profile',
            component: Profile
        },
        {
            path: '/profile/edit',
            name: 'profileEdit',
            component: ProfileEdit
        },
        {
            path: '/articles/:page?',
            name: 'articles',
            component: Articles
        }
    ],
});

const app = new Vue({
    el: '#app',
    store,
    components: { App },
    router,
});
