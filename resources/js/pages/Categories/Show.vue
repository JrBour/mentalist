<template>
    <div>
        <h1 class="display-3" v-if="category !== null">{{ category.name }}</h1>
        <h2 class="display-2">Articles</h2>
        <v-layout row wrap mt-5 mb-5 v-if="articles.length > 0">
            <ArticlesCard v-for="article in articles" :key="article.id" :article="article"/>
        </v-layout>
        <v-layout v-else>
            <p>No article</p>
        </v-layout>
        <v-btn color="success" @click="$router.push(`/categories/${category.id}/edit`)">
            Edit
        </v-btn>

    </div>
</template>

<script>
import ArticlesCard from '../../components/ArticlesCard';
import axios from 'axios';
export default {
    components: {
        ArticlesCard
    },
    data: () => ({
        category: null,
        articles : []
    }),
    mounted: async function(){
        const id = this.$route.params.id;
        const categoryResponse = await axios.get(`categories/${id}`);
        if (categoryResponse.status === 200){
            this.category = categoryResponse.data
        }
        const articlesResponse = await axios.get(`categories/${id}/articles`);
        if (articlesResponse.status === 200){
            this.articles = articlesResponse.data;
        }
    }
}
</script>

