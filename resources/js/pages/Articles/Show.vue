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
        <v-list two-line>
            <template v-for="comment in comments">
                <v-list-tile :key="comment.id">
                    <v-list-tile-avatar>
                        <img :src="'https://www.gravatar.com/avatar/' + comment.author_id.email_hashed">
                    </v-list-tile-avatar>

                    <v-list-tile-content>
                        <v-list-tile-sub-title v-html="comment.content"></v-list-tile-sub-title>
                    </v-list-tile-content>
                </v-list-tile>
            </template>
        </v-list>
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
export default {
    data: () => ({
        article: null,
        comments: [],
        content: '',
        fieldRules: [
            v => !!v || 'This field is required',
        ],
    }),
    mounted: async function(){
        const id = this.$route.params.id;
        const articleResponse = await axios.get(`articles/${id}`);
        if (articleResponse.status === 200){
            this.article = articleResponse.data
        }
        const commentsResponse = await axios.get(`articles/${id}/comments`);
        if (commentsResponse.status === 200){
            this.comments = commentsResponse.data.data
        }
    },
    methods: {
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

