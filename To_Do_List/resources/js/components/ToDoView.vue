<template>
    <div            
        @click="onClickToDetail(toDo.id)"
        class="text-center border-2 rounded hover:bg-gray-400 mb-1"     
    >
        <p class="text-start p-2" :style="hiddenText">{{ toDo.title }}</p>
        <!-- <span>{{ toDo.deadline !== null ? toDo.deadline : undefined_deadline }}</span> -->
        <p class="text-end p-2">{{ printDDay() }}</p>
    </div>
</template>

<script>
import dayjs from 'dayjs'

export default {
    props: {
        toDo: {
            type:Object,
            required: true,
            
        }
    },

    data(){
        const today = dayjs().format("YYYY-MM-DD").split('-').map(str => Number(str));
        const deadline = dayjs().format(this.toDo.deadline).split('-').map(str => Number(str));
        
        return {
            today: new Date(today[0], today[1], today[2]).getTime(),
            deadline: new Date(deadline[0], deadline[1], deadline[2]).getTime(),
            elapsedDay: '',
            hiddenText: {
                overflow: 'hidden',
                textOverflow: 'ellipsis',
                whiteSpace: 'nowrap'
            }
        }
    },

    created() {
        const elapsedMSec = this.deadline - this.today;
        this.elapsedDay = elapsedMSec / 1000 / 60 / 60 / 24;
    },

    methods: {
        onClickToDetail(id) {
            this.$emit('onClickToDetail', id);
        },

        printDDay() {
            this.toDo.deadline !== null  ? `D - ${this.elapsedDay}` :  "시간설정을 해주세요.";
            if ( this.toDo.deadline !== null ) {
                if ( this.elapsedDay < 0 ) {
                    return "Deadline 이미 지났어!! 왜 완료 못했니?!";
                } else {
                    return `D - ${this.elapsedDay}`;
                }
            } else {
                return "Deadline을 설정해주세요!";
            }            
        }
    },
} 
</script>