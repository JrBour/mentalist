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
                        :rules="passwordRules"
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
            ],
            passwordRules: [
                v => !!v || 'Password is required',
            ]
        }),
        methods :{
            submit: async function (){
                const data = {
                    email: this.email,
                    password: this.password,
                }
                const response = await axios.post('/api/login', data);
                if (response.status === 200){
                    localStorage.setItem('token', response.data.token);
                    localStorage.setItem('userId', response.data.id);
                    delete response.data.token;
                    this.$store.commit('setUser', response.data);
                    this.$router.push('/');
                }
            }
        }
    }
</script>

<style scoped>

</style>
