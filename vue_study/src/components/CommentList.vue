<template>
    <div>
        <div v-for="(comment, i) in comments" :key=i>
            <CommentListItem :commentObj="comment"/>
        </div>
        <CommentCreate :contentId="contentId" :reloadComment="reloadComment" />
    </div>    
</template>

<script>
import data from '@/data';
import CommentListItem from './CommentListItem';
import CommentCreate from './CommentCreate';

export default {
    name: 'CommentList',
    components: {
        CommentListItem,
        CommentCreate,
    },
    props: {
        contentId: Number,
    },
    data() {
        return {
            comments: data.Comment.filter(item => item.content_id === this.contentId)            
        }
    },
    methods: {
        reloadComment() {
            this.comments = data.Comment.filter(item => item.content_id === this.contentId)  
        }
    }
}
</script>