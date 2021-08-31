<template>
    <div class="flex-initial mt-2" v-if="categoryStatus !== 'important' && patternArr.indexOf(this.categoryStatus) < 0 && currentState === 0">
        <input 
            type="text" 
            v-model="title" 
            @keyup.enter="submit" 
            placeholder="ToDoを書いてください。" 
            class="mb-4  border-4 border-pink-400 w-full p-2 text-black"
            autofocus
        >
    </div>
</template>

<script>
export default {
    props: ['categoryStatus', 'currentState'],

    data() {
        return {
            title: '',
            patternArr: ["매일",'일', '월', '화', '수', '목', '금', '토'], //categoryStatus의 값과 비교해서, pattern에 해당되는지 확인하기 위함    
        }
    },

    methods: {
        //text form에서 @keyup.enter를 통해서 enter를 눌렀다가 땟을 경우 실행되는 함수
        submit() { 
            //if문을 쓴이유는 text가 있을 때만
                if(this.title === '') {
                    alert("글을 입력해야지!!");
                } else {
                    axios.post('api/todo/title', {
                        title: this.title,
                        group: this.categoryStatus,
                        currentState: this.currentState
                    }).then(res => {                    
                        console.log(res);
                        const lastPage = res.data.list_arr.last_page;
                        this.$emit('getResult', lastPage, this.categoryStatus);                             
                        // this.ToDoList.push(res.data.ToDoList);
                    });
                }         
                //text를 저장하고 나서는 text창 초기화
                this.title='';
        },
    }
}
</script>