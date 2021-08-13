<template>
    <div class="row">
        <div class="text-center mb-4"><span class="fs-1">To Do List of Jong-In</span></div>
        <input 
            type="text" 
            v-model="title" 
            @keyup.enter="submit" 
            placeholder="할 일을 적어주세요" 
            class="mb-4  border-4 border-pink-400 w-full" 
        >
        <template v-for="ToDo in NotCompleteToDOList" :key="ToDo.id">
            <ToDoView :to-do="ToDo" @onClickToDetail="onClickRedirect(ToDo.id)"/>                                  
        </template>

        <div class="text-center mt-2">
            <button type="button" class="btn btn-warning" @click="changeState('0')">할 일</button>            
            <button type="button" class="btn btn-primary mx-2" @click="changeState('1')">완료</button>      
            <button type="button" class="btn btn-primary" @click="changeState('all')">전체</button>      
        </div>            
    </div>
</template>

<script>
import ToDoView from './ToDoView.vue';

export default {
    setup: () => ({
        greeting: 'Hello World from Vue 3!'
    }),

    components: {
        ToDoView
    },

    data() {
        return {
            ToDoList: [],
            title: '',
            currentState: "0",        
        }
    },

    created() {
        axios.get('api/todo').then(res => {
                console.log(res);                
                this.ToDoList = res.data.list_arr;
        }).catch(error => {
            console.log(error)
        });
    },

    computed: {
        NotCompleteToDOList() {
            return this.ToDoList.filter(todo => this.currentState === "all" || todo.completion_is === this.currentState);
        }
    },

    methods:{
      onClickRedirect(id) {           
        window.location.href = `/todo/detail/${id}`;
      },

      submit() { 
          //if문을 쓴이유는 text가 있을 때만
            if(this.title) {
                axios.post('api/todo/title', {
                    title: this.title
                }).then(res => {                    
                    this.ToDoList = res.data.ToDoList;
                    // this.ToDoList.push(res.data.ToDoList);
                });
            }            
            //text를 저장하고 나서는 text창 초기화
            this.title='';
      },

      complete(id) {
          axios.get('api/todo/complete', {
              params: {
                  ToDoId: id
              }
          }).then(res => {
                console.log(res);
                this.ToDoList = res.data.list_arr;             
        });
      },

      changeState(value) {
          this.currentState = value;
          return;
      }
    }
}
</script>