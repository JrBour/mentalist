<template>
    <v-flex xs12 sm6>
        <v-card v-if="articleMutable">
            <v-card-title primary-title>
                <div>
                    <h3 class="headline mb-0">{{ articleMutable.title }}</h3>
                    <div> {{ articleMutable.content.slice(100) }}... </div>
                </div>
            </v-card-title>

            <v-card-actions>
                <v-btn flat color="orange" v-if="this.$store.getters.user !== null" @click="handleLike">{{ like ? 'Unlike' : 'Like' }}</v-btn>
                <v-btn flat color="orange" @click="$router.push(`/articles/${article.id}`)">Read more...</v-btn>
            </v-card-actions>
        </v-card>
    </v-flex>
</template>
<script>
    import axios from 'axios';
    export default {
        props: [
            'article'
        ],
        data: () => ({
            like : false,
            articleMutable: null
        }),
        mounted: async function(){
            this.articleMutable = this.article;
            const like = this.articleMutable.likes.map(like => like.user_id === +localStorage.getItem('userId'));
            this.like = like.includes(true);
        },
        methods: {
            handleLike: async function (){
                if (this.like){
                    const like = this.articleMutable.likes.find(like => like.user_id === +localStorage.getItem('userId'));
                    const response = await axios.delete(`likes/${like.id}`);
                    if (response.status === 204){
                        this.like = false;
                    }
                } else {
                    const data = {
                        article_id : this.article.id,
                        user_id: this.$store.getters.user.id
                    };
                    const response = await axios.post('likes', data);
                    if (response.status === 201){
                        this.like = true;
                    }
                }
                const article = await axios.get(`articles/${this.article.id}`);
                if (article.status === 200){
                    this.articleMutable = article.data.data;
                }
            }
        },
    }
</script>