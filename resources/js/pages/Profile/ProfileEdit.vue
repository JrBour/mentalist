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
                    <v-text-field
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
            fieldRules: [
                v => !!v || 'This field is required',
            ],
            emailRules: [
                v => !!v || 'E-mail is required',
                v => /.+@.+/.test(v) || 'E-mail must be valid'
            ]
        }),
        mounted(){
            this.user = this.$store.getters.user ? this.$store.getters.user : {};
        },
        methods :{
            submit: async function (){
                const response = await axios.put(`users/${this.user.id}`, this.user);
                if (response.status === 200){
                    delete this.user.password;
                    this.$store.commit('setUser', this.user)
                    this.$router.push('/profile');
                }
            }
        }
    }
</script>