<template>
    <div>
        <div v-if="article !== null">
            <h1 class="display-3">{{ article.title }}</h1>
            <p>{{ article.content }}</p>
            <p>Created at <b>{{ article.created_at }}</b></p>
        </div>
        <v-btn v-if="$store.getters.admin" color="success" @click="$router.push(`/articles/${article.id}/edit`)">
            Edit
        </v-btn>
        <v-btn v-if="$store.getters.admin" color="error" @click="remove(article.id)">
            Delete
        </v-btn>
        <v-btn flat color="orange" v-if="this.$store.getters.user !== null" @click="handleLike">{{ like ? 'Unlike' : 'Like' }}</v-btn>
       <CommentCard v-for="comment in comments" :key="comment.id" :comment="comment"/>
        <v-form v-if="$store.getters.users !== null">
            <v-container>
                <v-text-field
                    v-model="content"
                    label="Content"
                    :rules="fieldRules"
                    required
                ></v-text-field>
                <v-btn
                    color="success"
                    @click="submit"
                >
                Create comment
                </v-btn>
            </v-container>
        </v-form>
    </div>
</template>

<script>
import axios from 'axios';
import CommentCard from '../../components/CommentCard';
export default {
    components:{
        CommentCard
    },
    data: () => ({
        article: null,
        comments: [],
        content: '',
        like: false,
        fieldRules: [
            v => !!v || 'This field is required',
        ],
    }),
    mounted: async function(){
        const id = this.$route.params.id;
        const articleResponse = await axios.get(`articles/${id}`);
        if (articleResponse.status === 200){
            this.article = articleResponse.data.data
        }
        const commentsResponse = await axios.get(`articles/${id}/comments`);
        if (commentsResponse.status === 200){
            this.comments = commentsResponse.data.data
        }
        const like = this.article.likes.map(like => like.user_id === +localStorage.getItem('userId'));
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
        },
        remove: async function (id){
            const response = await axios.delete(`articles/${id}`);
            if (response.status === 204){
                this.$router.push('/articles');
            }
        },
        submit: async function (){
            const id = this.$route.params.id;
            const data = {
                content :this.content,
                author_id : this.$store.getters.user.id,
                article_id : id,
            }
            const response = await axios.post(`comments`, data);
            if (response.status === 201){
                this.content = '';
                const commentsResponse = await axios.get(`articles/${id}/comments`);
                if (commentsResponse.status === 200){
                    this.comments = commentsResponse.data.data
                }
            }
        },
    }
}
</script>

