<template>
    <v-form v-model="valid">
        <v-container>
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
                    Validate
                </v-btn>
        </v-container>
    </v-form>
</template>

<script>
    import axios from 'axios';
    export default {
        data: () => ({
            valid: false,
            email: '',
            password: '',
            emailRules: [
                v => !!v || 'E-mail is required',
                v => /.+@.+/.test(v) || 'E-mail must be valid'
            ]
        }),
        methods :{
            submit: function (){
                const data = {
                    email: this.email,
                    password: this.password,
                }
                const response = axios.post('/api/login', data);

                console.log(response);
            }
        }
    }
</script>

<style scoped>

</style>
