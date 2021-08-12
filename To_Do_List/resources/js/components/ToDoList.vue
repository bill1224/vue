<template>
    <div class="w-2/5">
        <div class="text-center mb-20"><span class="text-5xl">To Do List of Jong-In</span></div>
        <input 
            type="text" 
            v-model="title" 
            @keyup.enter="submit" 
            placeholder="할 일을 적어주세요" 
            class="mb-4 bg-pink-200 border-4 border-pink-400 w-full" 
        >
        <template  v-for="ToDo in NotCompleteToDOList" :key="ToDo.id">
            <ToDoView :to-do="ToDo" @onClickToDetail="onClickRedirect"/>                      
        </template>                   
    </div>
</template>
<script>
import ToDoView from './ToDoView.vue';

export default {
    components: {
        ToDoView
    },

    data() {
        return {
            ToDoList: [],
            title: '',            
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

    // watch: {
    //     ToDoList: function (newVal, oldVal) {
    //     this.NotCompleteToDOList = newVal.filter(todo => todo.completion_is === "0");
    //     }
    // },

    computed: {
        NotCompleteToDOList() {
            return this.ToDoList.filter(todo => todo.completion_is === "0");
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
      }
    }
}
</script>