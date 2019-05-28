<template>
    <v-container v-if="user !== null">
        <div v-if="user">
            <h1>{{user.firstname + ' ' + user.name}}</h1>
            <ul>
                <li>Username : <b>{{ user.username }}</b></li>
                <li>Email : <b>{{ user.email }}</b></li>
                <li>Role : <b>{{ user.admin ? 'Administrator' : 'User' }}</b></li>
            </ul>
            <v-btn color="success" @click="$router.push('profile/edit')">
                Edit profile
            </v-btn>
        </div>
        <div v-else>
            <h1>Loading</h1>
        </div>
    </v-container>
</template>

<script>
    import axios from 'axios';
    export default {
        data: () => ({
            user: null,
            loading: true
        }),
        mounted(){
            if (localStorage.getItem('userId') === null)
                this.$router.push('/login')
            this.user = this.$store.getters.user;
        }
    }
</script>