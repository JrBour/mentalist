<template>
    <v-list two-line>
        <v-list-tile :key="comment.id">
            <v-list-tile-avatar v-if="comment.author_id !== null" @click="$router.push(`/users/${comment.author_id.id}`)">
                <img :src="'https://www.gravatar.com/avatar/' + comment.author_id.email_hashed">
            </v-list-tile-avatar>

            <v-list-tile-content @click="$router.push(`/comments/${comment.id}`)">
                <v-list-tile-sub-title v-html="comment.content"></v-list-tile-sub-title>
            </v-list-tile-content>
        </v-list-tile>
    </v-list>
</template>
<script>
    export default {
        props: [
            'comment'
        ]
    }
</script>