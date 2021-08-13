<template>
    <div class=".container">
        <div class="text-center fs-1 mb-4">Set Detail</div>
        <div class="row">
            <div class="col">
                <textarea cols="60" rows="15" placeholder="상세내용을 적어주세요." v-model="description"></textarea>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <label for="date">Set Deadline</label>
            </div>
            <div class="col">
                <input type="date" id="date" v-model="deadline"> 
            </div>
        </div>
        <div>
            <button type="button" class="btn btn-warning mr-2" @click="submit(toDoId)">설정</button>
        </div>        
    </div>
</template>

<script>
export default {
    props: {
        toDoId: {
            type: Number,
            required: true,
        }
    },

    data() {
        return {
            description: '', 
            deadline: '',
        }
    },

    methods: {
        submit(id) {
            axios.post('../../api/todo/updateDetail', {
                    description: this.description,
                    deadline: this.deadline,
                    id: id
                }).then(res => {                    
                    console.log(res);
                });
        }
    }
}
</script>