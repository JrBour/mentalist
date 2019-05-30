<template>
  <div>
    <h1 class="display-4">Mentalist</h1>
    <h2 class="display-3">Articles</h2>
    <v-layout row wrap mt-5 mb-5>
        <ArticleCard v-for="article in articles" :key="article.id" :article="article"/>
    </v-layout>
    <h2>Users</h2>
    <v-flex xs12 sm6 offset-sm3>
        <v-card>
            <v-list two-line>
                <template v-for="user in users">
                    <v-list-tile v-if="user.id !== $store.getters.user.id" :key="user.id" avatar>
                        <v-list-tile-avatar @click="$router.push(`/users/${user.id}`)">
                          <img :src="'https://www.gravatar.com/avatar/' + user.email_hashed">
                        </v-list-tile-avatar>
                        <v-list-tile-content>
                            <v-list-tile-title v-html="user.firstname"></v-list-tile-title>
                            <v-list-tile-title v-html="user.lastname"></v-list-tile-title>
                            <v-list-tile-sub-title v-html="user.username"></v-list-tile-sub-title>
                        </v-list-tile-content>
                    </v-list-tile>
                </template>
            </v-list>
        </v-card>
    </v-flex>
  </div>
</template>

<script>
  import axios from 'axios';
  import ArticleCard from '../components/ArticleCard';

  export default {
    data: () => ({
      articles: [],
      users: [],
    }),
    components:{
      ArticleCard
    },
    mounted: async function(){
      const articlesResponse = await axios.get('articles');
      if (articlesResponse.status === 200){
        this.articles = articlesResponse.data.data;
      }
      const usersResponse = await axios.get('users');
      if (usersResponse.status === 200){
        this.users = usersResponse.data.data;
      }
    }
  }
</script>
