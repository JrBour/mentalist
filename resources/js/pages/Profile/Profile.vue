<template>  
    <v-container v-if="user !== null">
        <div v-if="user">
            <img :src="'https://www.gravatar.com/avatar/' + user.image" alt="">
            <h1 class="display-3 mt-4 nb-4">{{user.firstname + ' ' + user.name}}</h1>
            <ul class="mb-4">
                <li>Username : <b>{{ user.username }}</b></li>
                <li>Email : <b>{{ user.email }}</b></li>
                <li>Role : <b>{{ user.admin ? 'Administrator' : 'User' }}</b></li>
            </ul>
            <v-btn v-if="$route.params.id === null" color="success" @click="$router.push('profile/edit')">
                Edit profile
            </v-btn>
            <h2 class="display-2">{{ $route.params.id ? 'His' : 'Your' }} articles</h2>
            <v-layout>
                <ArticleCard v-for="article in articles" :key="article.id" :article="article"/>
            </v-layout>
            <v-btn v-if="$store.getters.admin" color="success" @click="$router.push(`/users/${user.id}/edit`)">
                Edit
            </v-btn>
            <v-btn v-if="$store.getters.admin" color="error" @click="remove(user.id)">
                Delete
            </v-btn>
        </div>
        <div v-else>
            <h1>Loading</h1>
        </div>
    </v-container>
</template>

<script>
    import axios from 'axios';
    import ArticleCard from '../../components/ArticleCard';
    export default {
        data: () => ({
            user: null,
            articles : null,
            loading: true
        }),
        components: {
            ArticleCard
        },
        mounted: async function(){
            if (localStorage.getItem('userId') === null)
                this.$router.push('/login')
            const id = this.$route.params.id;
            if (id){
                const response = await axios.get(`users/${id}`);
                if (response.status === 200)
                    this.user = response.data;
            } else {
                this.user = this.$store.getters.user;
            }
            const articleResponse = await axios.get(`users/${this.user.id}/articles`);
            if (articleResponse.status === 200)
                this.articles = articleResponse.data;
        },
        methods:{
            remove: async function (id){
                const response = await axios.delete(`users/${id}`);
                if (response.status === 204){
                    this.$router.push('/users');
                }
            },
        }
    }
</script>