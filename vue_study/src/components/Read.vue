<template>
    <div>
        <table>
            <tr v-for="(value,i) in data" :key=i @click="detail(i)">
                <td>{{ value.writer }}</td>
                <td>{{ value.title }}</td>
                <td>{{ value.content }}</td>
            </tr>
        </table>
        <button @click="write">글쓰기</button>
    </div>

</template>

<script>
import data from '../data/index.js'
export default {
    name: 'Read',
    data() {
        return {
            data: data
        }
    },
    methods: {
        write() {
            this.$router.push({
                path: 'create'
            })
        },
        detail(i){
            this.$router.push({
                //params를 넘겨줄때에는 push할때 path보단 name을 사용
                name: 'Detail',
                params: {
                    contentId: i
                }
            })
        }
    }
}
</script>