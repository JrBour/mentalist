<template>
    <div>
        <CommentCard v-if="comment !== null" :comment="comment" />
        <v-btn v-if="$store.getters.admin" color="success" @click="$router.push(`/comments/${comment.id}/edit`)">
            Edit
        </v-btn>
        <v-btn v-if="$store.getters.admin" color="error" @click="remove(comment.id)">
            Delete
        </v-btn>
    </div>
</template>
<script>
import CommentCard from '../../components/CommentCard';
import axios from 'axios';
export default {
    components:{
        CommentCard
    },
    data: () => ({
        comment: null,
    }),
    mounted: async function (){
        const id = this.$route.params.id;
        const response = await axios.get(`comments/${id}`);
        if (response.status === 200){
            this.comment = response.data.data;
        }
    },
    methods:{
         remove: async function (id){
            const response = await axios.delete(`comments/${id}`);
            if (response.status === 204){
                this.$router.push('/comments');
            }
        }
    }
}
</script>

