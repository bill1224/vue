<template>
    <div class=".container w-3/5">
        <div class="text-center fs-1 mb-4">Set Detail</div>
        <div class="row mb-2 border border-2 border-info">
            <div class="col">
                <textarea rows="15" placeholder="상세내용을 적어주세요." v-model="description"
                    class="w-full"></textarea>
            </div>
        </div>
        <div class="row border border-2 border-info mb-2 p-2">
            <div class="col">
                <label for="date">Set Deadline</label>                
            </div>
            <div class="col">
                <input type="date" id="date" v-model="deadline" class="border border-1 border-dark">
            </div>
        </div>
        <div class="text-red-900 font-black">
            {{ errorMessage }}
        </div>
        <div class="text-center">
            <button type="button" class="btn btn-warning" @click="submit(toDoId)">설정</button>
        </div>        
    </div>
</template>

<script>
import dayjs from 'dayjs'

export default {
    props: {
        toDoId: {
            type: Number,
            required: true,
        }
    },

    data() {
        const today = dayjs().format("YYYY-MM-DD").split('-').map(str => Number(str));        
        return {
            today: new Date(today[0], today[1], today[2]).getTime(),            
            elapsedDay: '',
            description: '', 
            deadline: '',
            errorMessage: '',
        }
    },

    methods: {
        submit(id) {
            if(this.description || this.deadline) {
                if(this.deadline) {
                    const deadline = this.deadline.split('-').map(str => Number(str));
                    const deadlineSec = new Date(deadline[0], deadline[1], deadline[2]).getTime();                    
                    const elapsedMSec = deadlineSec - this.today;
                    this.elapsedDay = elapsedMSec / 1000 / 60 / 60 / 24;                    
                    if(this.elapsedDay < 0) {
                        this.errorMessage = "DeadLine은 과거로 지정할 수 없어요";
                        return;
                    }
                }
                                
                axios.post('../../api/todo/updateDetail', {
                    description: this.description,
                    deadline: this.deadline,
                    id: id
                }).then(res => {                    
                    console.log(res);
                });
                window.location.href = `/todo/detail/${id}`;
            } else {
                this.errorMessage = "상세내용 or DeadLine을 작성해주세요."
            }                
        },        
    }
}
</script>