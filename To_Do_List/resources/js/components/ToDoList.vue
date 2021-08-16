<template>
    <div class="black-bg" v-if="modal_is_state">
        <div class="white-bg">
            <div>
                <input class="border-4 border-pink-400 w-full p-2 mb-2" type="text" v-model="groupName" placeholder="생성할 그룹명을 적어주세요.">
            </div>
            <div class="text-center">
                <button type="button" class="btn btn-primary mr-2" @click="createGroup">생성</button>
                <button type="button" class="btn btn-warning" @click="modal_is_state=false">닫기</button>
            </div>        
        </div>
    </div>

    <Header />

    <div class="flex h-full">
        <div class="w-1/5 border-r-2 border-solid border-gray-600">
            <Navbar :group-arr="Groups" @get-category-number="getCategoryNumber" @show-modal="showModal"/>
        </div>

        <div class="w-4/5 flex flex-col px-16">
            <div class="text-center mb-4"><span class="fs-1">To Do List of Jong-In</span></div>
            <!-- <div v-if="currentState === '0'">해야할 일 : {{ NotCompleteToDOList.length }} </div>
            <div v-else-if="currentState === '1'">완료한 일 : {{ NotCompleteToDOList.length }}</div>
            <div v-else>전체 : {{ NotCompleteToDOList.length }}</div> -->

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
                <ToDoView :to-do="ToDo" @onClickToDetail="onClickRedirect(ToDo.id)" @re-get-list="reGetList"/>                                  
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
import Navbar from "./Navbar.vue";
import ToDoView from './ToDoView.vue';

export default {
    components: {
        ToDoView,
        Header,
        Navbar
    },

    data() {
        return {            
            ToDoList: [],
            title: '',
            currentState: "0",
            Groups: [],
            value: 1004,
            modal_is_state: false,
            groupName: '',    
        }
    },

    created() {
        axios.get('api/todo').then(res => {
                console.log(res);                
                this.ToDoList = res.data.list_arr;
        });

        axios.get('api/group').then(res => {
            this.Groups = res.data.Groups;            
        });
    },

    computed: {
        NotCompleteToDOList() {
            if(this.value === 1004) {
                return this.ToDoList.filter(todo => this.currentState === "all" || todo.completion_is === this.currentState).sort(function (a, b) { return b.important_is - a.important_is });
                // return this.ToDoList.sort(function (a, b) { return b.important_is - a.important_is });
            } else if (this.value === 1141) {
                return this.ToDoList.filter(todo => this.currentState === "all" && todo.important_is === 1 || todo.important_is === 1 && todo.completion_is === this.currentState );
            } else {
                return this.ToDoList.filter(todo => this.currentState === "all" && todo.group === String(this.value) || todo.group === String(this.value) && todo.completion_is === this.currentState);
            }
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
                this.ToDoList = res.data.list_arr;             
        });
      },

      changeState(value) {
          this.currentState = value;
          return;
      },

      getCategoryNumber(value) {
          this.value = value
      },

      reGetList() {
          axios.get('api/todo').then(res => {                            
                this.ToDoList = res.data.list_arr;
        });
      },

      createGroup() {
          axios.post('api/group/create', {
              group_name: this.groupName
          }).then(res => {              
              this.modal_is_state = false;
              this.Groups.push(res.data.Group);
          });
      },

      showModal() {
          this.modal_is_state = true
      }
    }
}
</script>

<style scoped>
    .black-bg {
        width: 100%; height: 100%;
        background: rgba(57, 17, 90, 0.5); 
        position: fixed; padding: 20px;
    }
    .white-bg {
        width: 30%; background: white;
        border-radius: 8px;
        padding: 20px;
        position: absolute;
        top: 35%;
        left: 50%;        
        transform: translate(-50%, -50%)
    }
</style>