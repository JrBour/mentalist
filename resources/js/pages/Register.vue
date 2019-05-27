<template>
    <v-form v-model="valid">
        <v-container>
                    <v-text-field
                        v-model="firstname"
                        label="Firstname"
                        required
                    ></v-text-field>
                    <v-text-field
                        v-model="name"
                        label="Lastname"
                        required
                    ></v-text-field>
                    <v-text-field
                        v-model="username"
                        label="Username"
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
            emailRules: [
                v => !!v || 'E-mail is required',
                v => /.+@.+/.test(v) || 'E-mail must be valid'
            ]
        }),
        methods :{
            submit: async function (){
                console.log(this);
                const data = {
                    firstname: this.firstname,
                    username: this.username,
                    name: this.name,
                    email: this.email,
                    password: this.password
                }
                const response = await axios.post('/api/users', data);
                if (response.status === 201){
                    this.success = true;
                }
                console.log(response);
            }
        }
    }
</script>

<style scoped>

</style>
