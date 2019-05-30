<template>
    <div>
       <CommentCard v-for="comment in comments" :key="comment.id" :comment="comment"/>
        <div class="text-xs-center">
            <v-pagination
                v-if="totalPage !== 0"
                v-model="page"
                :length="totalPage"
                @input="changePage"
            ></v-pagination>
        </div>
    </div>
</template>
<script>
import CommentCard from '../../components/CommentCard';
import axios from 'axios';

export default {
    data: () => ({
        comments: [],
        content: '',
        totalPage : 0,
        page: 1
    }),
    components:{
        CommentCard
    },
    mounted: async function(){
        const response = await axios.get('comments');
        if (response.status === 200){
            this.comments = response.data.data;
            this.totalPage = response.data.meta.last_page;
        }
    },
    methods:{
        changePage: async function (page){
            const comments = await axios.get(`comments?page=${page}`);
            if (comments.status === 200){
                this.comments = comments.data.data;
            }
        }
    }
}
</script>

