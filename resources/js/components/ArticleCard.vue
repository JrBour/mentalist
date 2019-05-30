<template>
    <v-flex xs12 sm6>
        <v-card>
            <v-card-title primary-title>
                <div>
                    <h3 class="headline mb-0">{{ article.title }}</h3>
                    <div> {{ article.content.slice(100) }}... </div>
                </div>
            </v-card-title>

            <v-card-actions>
                <v-btn flat color="orange">Like</v-btn>
                <v-btn flat color="orange" @click="$router.push(`/articles/${article.id}`)">Read more...</v-btn>
            </v-card-actions>
        </v-card>
    </v-flex>
</template>
<script>
    export default {
        props: [
            'article'
        ]
    }
</script>