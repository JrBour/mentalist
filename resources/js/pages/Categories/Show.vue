<template>
    <div>
        <h1 class="display-3" v-if="category !== null">{{ category.name }}</h1>
        <h2 class="display-2">Articles</h2>
        <v-layout row wrap mt-5 mb-5 v-if="articles.length > 0">
            <ArticleCard v-for="article in articles" :key="article.id" :article="article"/>
        </v-layout>
        <v-layout v-else>
            <p>No article</p>
        </v-layout>
        <v-btn v-if="$store.getters.admin" color="success" @click="$router.push({ name: 'createArticle', params: { categoryId: category.id } })">
            Create new article
        </v-btn>
        <v-btn v-if="$store.getters.admin" color="success" @click="$router.push(`/categories/${category.id}/edit`)">
            Edit
        </v-btn>
        <v-btn v-if="$store.getters.admin" color="error" @click="remove(category.id)">
            Delete
        </v-btn>

    </div>
</template>

<script>
import ArticleCard from '../../components/ArticleCard';
import axios from 'axios';
export default {
    components: {
        ArticleCard
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
    },
    methods: {
        remove: async function (id){
            const response = await axios.delete(`categories/${id}`);
            if (response.status === 204){
                this.$router.push('/categories');
            }
        }
    }
}
</script>

