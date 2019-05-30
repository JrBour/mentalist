<template>
    <v-app id="inspire">
        <v-toolbar>
            <v-toolbar-items>
                <v-btn flat :to="{ name: 'home' }">
                    Home
                </v-btn>
                <v-btn flat :to="{ name: 'categories' }">
                    Categories
                </v-btn>
                <v-btn flat :to="{ name: 'articles' }">
                    Articles
                </v-btn>
                <v-btn flat :to="{ name: 'comments' }">
                    Comments
                </v-btn>
                <v-btn flat :to="{ name: 'users' }">
                    Users
                </v-btn>
                <v-btn v-if="$store.getters.user === null" flat :to="{ name: 'login' }">
                    Login
                </v-btn>
                <v-btn flat v-if="$store.getters.user === null" :to="{ name: 'register' }">
                    Register
                </v-btn>
                <v-btn v-if="$store.getters.user !== null" flat :to="{ name: 'profile' }">
                    {{ $store.getters.user.username }}
                </v-btn>
                <v-btn v-if="$store.getters.user !== null" flat @click="logout">
                    Logout
                </v-btn>
            </v-toolbar-items>
        </v-toolbar>
        <div class="container">
            <router-view></router-view>
        </div>
    </v-app>
</template>
<script>
    import axios from "axios"; 
    export default {
        mounted : async function (){
            const userId = localStorage.getItem('userId');
            if (userId !== null) {
                const user = await axios.get(`users/${userId}`);
                this.$store.commit('setUser', user.data);
                this.$store.commit('setAdmin', user.data.admin);
            }
        },
        methods: {
            logout(){
                this.$store.commit('setUser', null);
                this.$store.commit('setAdmin', false);
                localStorage.clear()
                this.$router.push('/');
            }
        }
    }
</script>
