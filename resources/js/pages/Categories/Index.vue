<template>
    <div>
        <h1 class="display-4">Categories</h1>
        <v-layout row wrap mt-5 mb-5>
            <CategoryCard v-for="category in categories" :key="category.id" :category="category"/>
        </v-layout>
        <v-btn color="success" @click="$router.push('/categories/create')">
            Create new category
        </v-btn>
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
import CategoryCard from '../../components/CategoryCard';

export default {
    components: {
        CategoryCard
    },
    data: () => ({
        categories: null,
        totalPage: 0,
        page: 1
    }),
    methods : {
        changePage: async function (page){
            const categories = await axios.get(`categories?page=${page}`);
            if (categories.status === 200){
                this.categories = categories.data.data;
            }
        }
    },
    mounted: async function (){
        const categories = await axios.get('categories');
        if (categories.status === 200){
            this.categories = categories.data.data;
            this.totalPage = categories.data.last_page;
        }
    }
}
</script>

