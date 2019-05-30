<template>
    <v-container v-if="user !== null">
        <div v-if="user">
            <img :src="'https://www.gravatar.com/avatar/' + user.image" alt="">
            <h1 class="display-4">{{user.firstname + ' ' + user.name}}</h1>
            <ul>
                <li>Username : <b>{{ user.username }}</b></li>
                <li>Email : <b>{{ user.email }}</b></li>
                <li>Role : <b>{{ user.admin ? 'Administrator' : 'User' }}</b></li>
            </ul>
            <v-btn color="success" @click="$router.push('profile/edit')">
                Edit profile
            </v-btn>
            <h2 class="display-3">Your articles</h2>
            <v-layout>
                <ArticleCard v-for="article in articles" :key="article.id" :article="article"/>
            </v-layout>
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
            this.user = this.$store.getters.user;
            const articleResponse = await axios.get(`users/${this.user.id}/articles`);

            if (articleResponse.status === 200)
                this.articles = articleResponse.data;
            // if ()
            // this.article
        }
    }
</script>