<template>
    <div>
        <v-form>
            <v-text-field
                v-model="search"
                label="Search by name"
            ></v-text-field>
            <v-btn
                color="success"
                @click="searchUsers"
            >
                Search
            </v-btn>
            <v-btn
                color="warning"
                @click="reset"
            >
                Reset
            </v-btn>
        </v-form>
        <v-flex xs12 sm6 offset-sm3>
            <v-card>
                <v-list two-line>
                    <template v-for="user in users">
                        <v-list-tile v-if="user.id !== $store.getters.user.id" :key="user.id" avatar>
                            <v-list-tile-avatar @click="$router.push(`/users/${user.id}`)">
                              <img :src="'https://www.gravatar.com/avatar/' + user.email_hashed">
                            </v-list-tile-avatar>
                            <v-list-tile-content>
                                <v-list-tile-title v-html="user.firstname"></v-list-tile-title>
                                <v-list-tile-title v-html="user.lastname"></v-list-tile-title>
                                <v-list-tile-sub-title v-html="user.username"></v-list-tile-sub-title>
                            </v-list-tile-content>
                        </v-list-tile>
                    </template>
                </v-list>
            </v-card>
        </v-flex>
        <div class="text-xs-center">
            <v-pagination
                v-if="totalPage !== 0 && !searching"
                v-model="page"
                :length="totalPage"
                @input="changePage"
            ></v-pagination>
        </div>
    </div>
</template>
<script>
import axios from 'axios';

export default {
    data: () => ({
        users: [],
        searching: false,
        search: '',
        totalPage : 0,
        page: 1
    }),
    mounted: async function(){
        const response = await axios.get('users');
        if (response.status === 200){
            this.users = response.data.data;
            this.totalPage = response.data.last_page;
        }
    },
    methods:{
        changePage: async function (page){
            const users = await axios.get(`users?page=${page}`);
            if (users.status === 200){
                this.users = users.data.data;
            }
        },
        searchUsers: async function (){
            const users = await axios.get(`users?search=${this.search}`);
            if (users.status === 200){
                this.users = users.data;
                this.searching = true;
            }
        },
        reset: async function (){
            const response = await axios.get('users');
            if (response.status === 200){
                this.users = response.data.data;
                this.searching = false;
                this.totalPage = response.data.last_page;
            }   
        }
    }
}
</script>

