<template>
    <v-flex xs12 sm6>
        <v-card>
            <v-card-title primary-title>
                <h3 class="headline mb-0">{{ category.name }}</h3>
            </v-card-title>
        </v-card>
    </v-flex>
</template>
<script>
    export default {
        props: [
            'category'
        ]
    }
</script>