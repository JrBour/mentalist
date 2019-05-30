<template>
    <v-form v-model="valid">
        <v-container>
            <v-text-field
                v-model="article.title"
                label="Title"
                :rules="fieldRules"
                required
            ></v-text-field>
            <v-text-field
                v-model="article.content"
                label="Content"
                :rules="fieldRules"
                required
            ></v-text-field>
            <v-btn
                :disabled="!valid"
                color="success"
                @click="submit"
            >
                {{ id ? 'Edit' : 'Create' }}
            </v-btn>
        </v-container>
    </v-form>
</template>
<script>
import axios from 'axios';
export default {
    data: () => ({
        valid: false,
        article: {
            title: '',
            content: ''
        },
        categories: [],
        id : null,
        fieldRules: [
            v => !!v || 'This field is required',
        ],
    }),
    mounted: async function (){
        this.id = this.$route.params.id;
        if (this.id){
            const response = await axios.get(`articles/${this.id}`);
            if (response.status === 200){
                this.article.title = response.data.title;
                this.article.content = response.data.content;
                this.article.categoryId = response.data.category_id;
            }
        }
    },
    methods: {
        submit: async function (){
            const data = {
                    title: this.article.title,
                    content: this.article.content,
                    author_id: this.$store.getters.user.id,
                    category_id : this.$route.params.categoryId || this.article.categoryId 
                };
            if (this.id){
                const response = await axios.put(`articles/${this.id}`, data);
                if (response.status === 200){
                    this.name = response.data.name;
                    this.$router.push(`/articles/${this.id}`);
                }
            } else {
                const response = await axios.post(`articles`, data);
                if (response.status === 201){
                    this.$router.push('/articles');
                }
            }
        }
    }
}
</script>

