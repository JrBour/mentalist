<template>
    <div>
        <h1 class="display-4">Categories</h1>
        <v-layout row wrap mt-5 mb-5>
            <CategoryCard v-for="category in categories" :key="category.id" :category="category"/>
        </v-layout>
        <v-btn color="success" @click="$router.push('/categories/create')">
            Create new category
        </v-btn>
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
import CategoryCard from '../../components/CategoryCard';

export default {
    components: {
        CategoryCard
    },
    data: () => ({
        categories: null,
        total: 0,
        page: 1
    }),
    methods : {
        next: async function (page){
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
            this.total = categories.data.total;
        }
    }
}
</script>

