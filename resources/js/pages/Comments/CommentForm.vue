<template>
    <v-form v-model="valid">
        <v-container>
            <v-text-field
                v-model="comment.content"
                label="Content"
                :rules="fieldRules"
                required
            ></v-text-field>
            <v-btn
                :disabled="!valid"
                color="success"
                @click="submit"
            >
                Edit
            </v-btn>
        </v-container>
    </v-form>
</template>
<script>
import axios from 'axios';
export default {
    data: () => ({
        valid: false,
        comment : {
            content: '',
        },
        fieldRules: [
            v => !!v || 'This field is required',
        ],
    }),
    mounted: async function (){
        const id = this.$route.params.id;
        const response = await axios.get(`comments/${id}`);
        if (response.status === 200){
            this.comment.content = response.data.data.content;
            this.comment.articleId = response.data.data.article_id;
        }
    },
    methods: {
        submit: async function (){
            const id = this.$route.params.id;
            const data = {
                content: this.comment.content,
                author_id: this.$store.getters.user.id,
                article_id : this.comment.articleId
            };
            const response = await axios.put(`comments/${id}`, data);
            if (response.status === 200){
                this.$router.push(`/comments/${id}`);
            }
        }
    }
}
</script>

