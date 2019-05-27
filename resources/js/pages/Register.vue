<template>
    <v-form v-model="valid">
        <v-container>
                    <v-text-field
                        v-model="firstname"
                        label="Firstname"
                        :rules="fieldRules"
                        required
                    ></v-text-field>
                    <v-text-field
                        v-model="name"
                        label="Lastname"
                        :rules="fieldRules"
                        required
                    ></v-text-field>
                    <v-text-field
                        v-model="username"
                        label="Username"
                        :rules="fieldRules"
                        required
                    ></v-text-field>
                    <v-text-field
                        v-model="email"
                        :rules="emailRules"
                        label="E-mail"
                        required
                    ></v-text-field>
                    <v-text-field
                        v-model="password"
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
                    Sign up
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
            firstname: '',
            username: '',
            name: '',
            email: '',
            password: '',
            fieldRules: [
                v => !!v || 'This field is required',
            ],
            emailRules: [
                v => !!v || 'E-mail is required',
                v => /.+@.+/.test(v) || 'E-mail must be valid'
            ]
        }),
        methods :{
            submit: async function (){
                const data = {
                    firstname: this.firstname,
                    username: this.username,
                    name: this.name,
                    email: this.email,
                    password: this.password
                }
                const response = await axios.post('/api/users', data);
                if (response.status === 201){
                    this.$router.push('/login');
                }
            }
        }
    }
</script>

<style scoped>

</style>
