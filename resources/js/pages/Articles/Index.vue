<template>
    <div>
        <h1 class="display-4">Articles</h1>
        <v-layout row wrap mt-5 mb-5>
            <ArticleCard v-for="article in articles" :key="article.id" :article="article"/>
        </v-layout>
        <v-flex xs12 sm6>
            <v-pagination
                v-if="total !== 0"
                v-model="page"
                :length="(total%10 === 0) ? total/10 : total/10+1"
                @input="next"
            ></v-pagination>
        </v-flex>
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
        total: 0,
        page: 1
    }),
    methods : {
        next: async function (page){
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
            this.total = articles.data.total;
        }
    }
}
</script>

