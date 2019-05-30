<template>
    <v-form v-model="valid">
        <v-container v-if="user !== null">
                    <v-text-field
                        v-model="user.firstname"
                        label="Firstname"
                        :rules="fieldRules"
                        required
                    ></v-text-field>
                    <v-text-field
                        v-model="user.name"
                        label="Lastname"
                        :rules="fieldRules"
                        required
                    ></v-text-field>
                    <v-text-field
                        v-model="user.username"
                        label="Username"
                        :rules="fieldRules"
                        required
                    ></v-text-field>
                    <v-text-field
                        v-model="user.email"
                        :rules="emailRules"
                        label="E-mail"
                        required
                    ></v-text-field>
                    <v-checkbox
                        label="Admin"
                        v-model="user.admin"
                    ></v-checkbox>
                    <v-text-field
                        v-if="id === null"
                        v-model="user.password"
                        label="Password"
                        :rules="fieldRules"
                        type="password"
                        required
                    ></v-text-field>
                <v-btn
                    :disabled="!valid"
                    color="success"
                    @click="submit"
                >
                    Edit
                </v-btn>
            <p v-show="success">Register successful !</p>
        </v-container>
    </v-form>
</template>

<script>
    import axios from 'axios';
    export default {
        data: () => ({
            valid: false,
            success:false,
            user : null,
            id : null,
            fieldRules: [
                v => !!v || 'This field is required',
            ],
            emailRules: [
                v => !!v || 'E-mail is required',
                v => /.+@.+/.test(v) || 'E-mail must be valid'
            ]
        }),
        mounted: async function(){
            this.id = this.$route.params.id;
            if (this.id !== null){
                const response = await axios.get(`users/${this.id}`);
                if (response.status === 200)
                    this.user = response.data; 
            } else {
                this.user = this.$store.getters.user ? this.$store.getters.user : {};
            }
        },
        methods :{
            submit: async function (){

                const response = await axios.put(`users/${this.user.id}`, this.user);
                if (response.status === 200){
                    delete this.user.password;
                    if (this.id === null){
                        this.$store.commit('setUser', this.user)
                        this.$router.push('/profile');
                    } else {
                        this.$router.push(`/users/${this.id}`);
                    }
                }
            }
        }
    }
</script>