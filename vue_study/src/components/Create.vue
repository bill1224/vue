<template>
    <div>
        <b-input v-model="subject" placeholder="제목을 입력해주세요."></b-input>
        <b-form-textarea v-model="context" placeholder="내용을 입력해주세요"></b-form-textarea>
        <b-button @click="updateMode ? updateContent() : uploadContent() ">{{ updateMode ? "수정" : "작성" }}</b-button>
        <b-button @click="cancle">취소</b-button>
    </div>
</template>

<script>
import data from '@/data';

export default {
    name: 'Create',
    
    data() {        
        return {                    
            subject: '',
            context: '',
            user_id: 1,
            createdAt: '2021-08-05 21:07:33',
            updatedAt: null,
            updateMode: Number(this.$route.params.contentId) > 0 ? true : false,
        }        
    },
    created() {
        if (Number(this.$route.params.contentId) > 0){
            const contentId = Number(this.$route.params.contentId)
            const contentData = data.Content.filter(content => content.content_id === contentId)[0]
            this.subject = contentData.title
            this.context = contentData.context
        }        
    },

    methods: {
        cancle() {
            this.$router.push({
                path: "/board/free"
            })
        },
        uploadContent() {
            let item = data.Content.sort((a,b) => {return b.content_id - a.content_id})[0].content_id
            const content_id = item + 1
            data.Content.push({
                content_id: content_id,
                user_id: this.user_id,
                title: this.subject,
                context: this.context,
                created_at: this.createdAt,
                updated_at: this.updatedAt,
            })
            this.$router.push({
                path: "/board/free"
            })
        },
        updateContent() {            
            const contentId = Number(this.$route.params.contentId)
            const contentData = data.Content.filter(content => content.content_id === contentId)[0]
            contentData.title = this.subject
            contentData.context = this.context
            this.$router.push({
                path: `/board/free/detail/${contentId}`
            })
        }
    }
}
</script>