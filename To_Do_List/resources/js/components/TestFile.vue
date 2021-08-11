<template>
    <div>
        <input type="text" v-model="title" @keyup.enter="submit">        
        <div v-for="(ToDo, i) in ToDoList"
            :key="i"
            @click="complete(ToDo.id)"
            class="text-center border-2 rounded"     
        >
            {{ ToDo.title }}
        </div>            
    </div>
</template>
<script>
export default {
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

    methods:{
      onClickRedirect() {   
          window.open("https://google.com", "_blank");    
      },

      submit() { 
          //if문을 쓴이유는 text가 있을 때만 저장하겠다는 뜻 
            if(this.title) {
                axios.post('api/todo/title', {
                    title: this.title
                }).then(res => {                    
                    this.ToDoList.push(res.data.ToDoList);
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
                tihs.ToDoList = res.data.list_arr;
        });
      }
    }
}
</script>