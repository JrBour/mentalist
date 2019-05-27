<template>
    <v-app id="inspire">
        <v-toolbar>
            <v-toolbar-items>
                <v-btn flat :to="{ name: 'home' }">
                    Home
                </v-btn>
                <v-btn flat :to="{ name: 'login' }">
                    Login
                </v-btn>
                <v-btn flat :to="{ name: 'register' }">
                    Register
                </v-btn>
            </v-toolbar-items>
        </v-toolbar>
        <div class="container">
            <router-view></router-view>
        </div>
    </v-app>
</template>
<script>
    export default {}
</script>
