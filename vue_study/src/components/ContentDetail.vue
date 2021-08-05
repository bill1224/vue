<template>
    <div>
        <b-card>
            <div class="content-detail-content-info">
                <div class="content-detail-content-info-left">
                    <div class="content-detail-content-info-left-number">
                        {{ contentId }}
                    </div>
                    <div class="content-detail-content-info-left-subject">
                        {{ title }}
                    </div>
                </div>
                <div class="content-detail-content-info-right">
                    <div class="content-detail-content-info-right-user">
                        글쓴이: {{ user }}
                    </div>
                    <div class="content-detail-content-info-right-created">
                        등록일: {{ created }}
                    </div>
                </div>
            </div>
            <div class="content-detail-content">
                {{ context }}
            </div>
            <div class="content-detail-button">
                <b-button variant="primary" @click="updateContent">수정</b-button>
                <b-button variant="primary" @click="deleteData">삭제</b-button>
            </div>
            <div class="content-detail-content">
                <!-- 부모 컴포넌트가 자식 컴포넌트로 값을 보낼 때 사용 -->
                <CommentList :contentId="contentId"/>
            </div>
        </b-card>
    </div>
</template>

<script>
import data from '@/data';
import CommentList from './CommentList';

export default {    
    name: "ContentDetail",
    components: {
        CommentList
    },
    data() {
        const contentId = Number(this.$route.params.contentId)
        const contentData = data.Content.filter(content => content.content_id === contentId)[0]
        return {
            contentId: contentId,
            title: contentData.title,
            context: contentData.context,
            user: data.User.filter(user => user.user_id === contentData.user_id)[0].name,
            created: contentData.created_at,
        }
    },
    methods: {
        deleteData() {
            //조건함수를 인자로 받아 조건을 만족하는 원소의 인데스를 반환한다. 
            const content_index = data.Content.findIndex(item => item.content_id === this.contentId);
            data.Content.splice(content_index, 1)
            this.$router.push({
                path:"/board/free",
            })
        },
        updateContent() {
            this.$router.push({
                // path: `/board/free/create/${this.contentId}`
                name: 'Create',
                params: {
                    contentId: this.contentId
                } 
            })
        }
    }
    
}
</script>

<style scoped>
.content-detail-content-info {
  border: 1px solid black;
  display: flex;
  justify-content: space-between;
}
.content-detail-content-info-left {
  width: 720px;
  display: flex;
  flex-direction: row;
  justify-content: space-between;
  align-items: center;
  padding: 1rem;
}
.content-detail-content-info-right {
  width: 300px;
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  padding: 1rem;
}
.content-detail-content {
  border: 1px solid black;
  margin-top: 1rem;
  padding-top: 1rem;
  min-height: 720px;
}
.content-detail-button {
  border: 1px solid black;
  margin-top: 1rem;
  padding: 2rem;
}
.content-detail-comment {
  border: 1px solid black;
  margin-top: 1rem;
  padding: 2rem;
}
</style>