<template>
    <div>
        {{ page }}
    </div>
</template>

<script>
    import axios from 'axios';

    export default {
        name: "Articles",
        data: () => ({
            articles: [],
            page: 1,
        }),
        mounted: async function () {
            console.log(typeof this.$route.params.page);
            this.page = (typeof this.$route.params.page === 'string') ? this.$route.params.page : 1;
            const articlesResponse = await axios.get(`/api/articles?page=${this.page}`);
            this.articles =  articlesResponse.data.data
        },
    }
</script>