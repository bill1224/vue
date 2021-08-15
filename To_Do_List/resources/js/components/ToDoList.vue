<template>
    <Header />    

    <div class="flex h-full">
        <div class="w-1/5 border-r-2 border-solid border-gray-600">
            <div>
                <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 100 100"><path d="M48.856 22.731a3.56 3.56 0 00.906-3.671 3.56 3.56 0 00-2.892-2.438l-12.092-1.757a1.58 1.58 0 01-1.19-.865L28.182 3.043a3.56 3.56 0 00-3.212-1.996 3.56 3.56 0 00-3.211 1.996L16.352 14c-.23.467-.676.79-1.191.865L3.069 16.623A3.557 3.557 0 00.178 19.06a3.56 3.56 0 00.906 3.671l8.749 8.528c.373.364.544.888.456 1.4L8.224 44.702a3.559 3.559 0 001.424 3.502 3.552 3.552 0 003.772.273l10.814-5.686a1.583 1.583 0 011.472 0l10.815 5.686a3.568 3.568 0 003.772-.273 3.559 3.559 0 001.424-3.502L39.651 32.66a1.582 1.582 0 01.456-1.4l8.749-8.529zM37.681 32.998l2.065 12.042a1.553 1.553 0 01-.629 1.547 1.558 1.558 0 01-1.665.121l-10.815-5.687a3.588 3.588 0 00-3.334.001L12.49 46.708a1.56 1.56 0 01-1.666-.121 1.554 1.554 0 01-.629-1.547l2.065-12.042a3.581 3.581 0 00-1.03-3.17l-8.75-8.529a1.55 1.55 0 01-.4-1.621c.19-.586.667-.988 1.276-1.077l12.091-1.757a3.576 3.576 0 002.697-1.959l5.407-10.957a1.551 1.551 0 011.418-.881c.616 0 1.146.329 1.419.881l5.407 10.957a3.575 3.575 0 002.696 1.959l12.092 1.757a1.552 1.552 0 011.276 1.077c.19.585.041 1.191-.4 1.621l-8.749 8.528a3.58 3.58 0 00-1.029 3.171z"/></svg>
                <svg width="75" height="75" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg"><path d="M23.363 8.584l-7.378-1.127L12.678.413c-.247-.526-1.11-.526-1.357 0L8.015 7.457.637 8.584c-.606.093-.848.83-.423 1.265l5.36 5.494-1.267 7.767c-.101.617.558 1.08 1.103.777L12 20.245l6.59 3.643c.54.3 1.205-.154 1.103-.777l-1.267-7.767 5.36-5.494c.425-.436.182-1.173-.423-1.266z" fill="#ffc107"/></svg>
            </div>            
        </div>

        <div class="w-4/5 flex flex-col px-16">
            <div class="text-center mb-4"><span class="fs-1">To Do List of Jong-In</span></div>
            <div v-if="currentState === '0'">해야할 일 : {{ NotCompleteToDOList.length }} </div>
            <div v-else-if="currentState === '1'">완료한 일 : {{ NotCompleteToDOList.length }}</div>
            <div v-else>전체 : {{ NotCompleteToDOList.length }}</div>

            <div class="flex-initial p-2">
                <input 
                    type="text" 
                    v-model="title" 
                    @keyup.enter="submit" 
                    placeholder="할 일을 적어주세요" 
                    class="mb-4  border-4 border-pink-400 w-full p-2" 
                >
            </div>
            
            <template v-for="ToDo in NotCompleteToDOList" :key="ToDo.id" class="flex-1">
                <ToDoView :to-do="ToDo" @onClickToDetail="onClickRedirect(ToDo.id)"/>                                  
            </template>

            <div class="text-center mt-2">
                <button type="button" class="btn btn-warning" @click="changeState('0')">할 일</button>            
                <button type="button" class="btn btn-primary mx-2" @click="changeState('1')">완료</button>      
                <button type="button" class="btn btn-primary" @click="changeState('all')">전체</button>      
            </div>         
        </div>
    </div>
    

    
</template>

<script>
import Header from "./Header.vue";
import ToDoView from './ToDoView.vue';

export default {
    components: {
        ToDoView,
        Header
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
            if(this.title === '') {
                alert("글을 입력해야지!!");
            } else {
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