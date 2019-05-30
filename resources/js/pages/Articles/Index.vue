<template>
    <div>
        <h1 class="display-4">Articles</h1>
        <v-layout row wrap mt-5 mb-5>
            <ArticleCard v-for="article in articles" :key="article.id" :article="article"/>
        </v-layout>
        <div class="text-xs-center">
            <v-pagination
                v-if="totalPage !== 0"
                v-model="page"
                :length="totalPage"
                @input="changePage"
            ></v-pagination>
        </div>
    </div>
</template>
<script>
import axios from 'axios';
import ArticleCard from '../../components/ArticleCard';

export default {
    components: {
        ArticleCard
    },
    data: () => ({
        articles: null,
        totalPage: 0,
        page: 1
    }),
    methods : {
        changePage: async function (page){
            const articles = await axios.get(`articles?page=${page}`);
            if (articles.status === 200){
                this.articles = articles.data.data;
            }
        }
    },
    mounted: async function (){
        const articles = await axios.get('articles');
        if (articles.status === 200){
            this.articles = articles.data.data;
            this.totalPage = articles.data.meta.last_page;
        }
    }
}
</script>

