<template>
    <div>
        <div>{{ data.writer }}</div>
        <div>{{ data.title }}</div>
        <div>{{ data.content }}</div>
        <button @click="updateData">수정</button>
        <button @click="deleteData(index)">삭제</button>        
    </div>
</template>

<script>
import data from '@/data';
export default {
    name: 'detail',
    data() {
        const index = this.$route.params.contentId
        return {
            data: data[index],
            index: index
        }
    },
    methods: {
        // 특정인덱스인 값을 삭제할 때 사용함
        deleteData() {
            data.splice(this.index, 1)
            this.$router.push({
                path:"/"
            })
        },
        updateData() {
            this.$router.push({
                name: 'Create',
                params: {
                    contentId: this.index
                }
            })
        }
    },
}
</script>