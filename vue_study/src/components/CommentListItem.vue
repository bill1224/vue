<template>
    <div>        
        <div>
            <div class="comment-list-item-name">
                <div>{{ user_name }}</div>
                <div>{{ commentObj.created_at }}</div>
            </div>
            <div class="comment-list-item-context">{{ commentObj.context }}</div>

            <div class="comment-list-item-button">
                <b-button variant="info">수정</b-button>
                <b-button variant="info">삭제</b-button>
                <b-button variant="info" @click="subCommentToggle">댓글 달기</b-button>
            </div>
        </div>
        <template v-if="subCommentCreateToggle">
            <CommentCreate :isSubComment=true :commentId="commentObj.comment_id" :reloadSubComment="reloadSubComment" :subCommentToggle="subCommentToggle"/>
        </template>      
        <template v-if="subCommentList.length > 0">
            <div v-for="(subComment, i) in subCommentList" :key="i">
                <div class="comment-list-item-name">
                    <div>{{ subComment.user_name }}</div>
                    <div>{{ subComment.created_at }}</div>
                </div>
                <div class="comment-list-item-context">{{ subComment.context }}</div>

                <div class="comment-list-item-button">
                    <b-button variant="info">수정</b-button>
                    <b-button variant="info" @click="delteSubComment">삭제</b-button>
                </div>
            </div>
        </template>        
    </div>
</template>

<script>
import data from '@/data';
import CommentCreate from './CommentCreate';

export default {
    name: 'CommentListItem',
    props: {
        commentObj: Object,
    },
    components: {
        CommentCreate,
    },
    data() {              
        return {         
            user_name: data.User.filter(user => user.user_id === this.commentObj.user_id)[0].name,            
            subCommentList: data.SubComment.filter(item => item.comment_id === this.commentObj.comment_id)
            .map(subCommentItem => ({...subCommentItem, user_name: data.User.filter(item => item.user_id === subCommentItem.user_id)[0].name})),
            subCommentCreateToggle: false,
        }
    },
    methods: {
        subCommentToggle() {
            this.subCommentCreateToggle = !this.subCommentCreateToggle;
        },
        reloadSubComment() {
            this.subCommentList = data.SubComment.filter(item => item.comment_id === this.commentObj.comment_id)
            .map(subCommentItem => ({...subCommentItem, user_name: data.User.filter(item => item.user_id === subCommentItem.user_id)[0].name}))
        },
        // delteSubComment() {

        // }
    }
}
</script>

<style scoped>
.comment-list-item {
  display: flex;
  justify-content: space-between;
  padding-bottom: 1em;
}
.comment-list-item-name {
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  border: 0.5px solid black;
  padding: 1em;
}
.comment-list-item-context {
  display: flex;
  justify-content: center;
  align-items: center;
  width: 50em;
  border: 0.5px solid black;
}
.comment-list-item-button {
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  border: 0.5px solid black;
  padding: 1em;
}
.btn {
  margin-bottom: 1em;
}
.comment-list-item-subcomment-list {
  display: flex;
  justify-content: space-between;
  padding-bottom: 1em;
  margin-left: 10em;
}
</style>