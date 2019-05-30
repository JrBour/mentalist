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

import Categories from './pages/Categories/Index';
import ShowCategory from './pages/Categories/Show';
import CategoryForm from './pages/Categories/CategoryForm';

import Articles from './pages/Articles/Index';
import ShowArticle from './pages/Articles/Show';
import ArticleForm from './pages/Articles/ArticleForm';

import Profile from './pages/Profile/Profile';
import ProfileEdit from './pages/Profile/ProfileEdit';

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
            path: '/categories',
            name: 'categories',
            component: Categories
        },
        {
            path: '/categories/create',
            name: 'createCategory',
            component: CategoryForm
        },
        {
            path: '/categories/:id',
            name: 'showCategory',
            component: ShowCategory
        },
        {
            path: '/categories/:id/edit',
            name: 'editCategory',
            component: CategoryForm
        },
        {
            path: '/articles',
            name: 'articles',
            component: Articles
        },
        {
            path: '/articles/create',
            name: 'createArticle',
            component: ArticleForm,
            props: { categoryId: false }
        },
        {
            path: '/articles/:id',
            name: 'showArticle',
            component: ShowArticle
        },
        {
            path: '/articles/:id/edit',
            name: 'editArticle',
            component: ArticleForm
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
        }
    ],
});

const app = new Vue({
    el: '#app',
    store,
    components: { App },
    router,
});
