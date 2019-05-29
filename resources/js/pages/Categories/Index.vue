<template>
    <div>
        <h1 class="display-4">Categories</h1>
        <v-layout row wrap>
            <CategoryCard v-for="category in categories" :key="category.id" :category="category"/>
        </v-layout>
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
        categories: null
    }),
    mounted: async function (){
        const categories = await axios.get('categories');
        if (categories.status === 200){
            this.categories = categories.data.data;
        }
    }
}
</script>

