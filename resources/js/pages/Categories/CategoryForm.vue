<template>
    <v-form v-model="valid">
        <v-container>
            <v-text-field
                v-model="name"
                label="Name"
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
        name: '',
        id : null,
        fieldRules: [
            v => !!v || 'This field is required',
        ],
    }),
    mounted: async function (){
        this.id = this.$route.params.id;
        if (this.id){
            const response = await axios.get(`categories/${this.id}`);
            if (response.status === 200){
                this.name = response.data.name;
            }
        }
    },
    methods: {
        submit: async function (){
            if (this.id){
                const response = await axios.put(`categories/${this.id}`, {name : this.name});
                if (response.status === 200){
                    this.name = response.data.name;
                    this.$router.push(`/categories/${this.id}`);
                }
            } else {
                const response = await axios.post(`categories`, {name : this.name});
                if (response.status === 201){
                    this.$router.push('/categories');
                }
            }
        }
    }
}
</script>

