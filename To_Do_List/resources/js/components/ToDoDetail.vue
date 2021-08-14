<template>
    <div class="container w-3/5">
        <div class="text-center fs-1 mb-4" @click="redirectToHome">To Do Detail</div>        
        <div class="grid grid-cols-6 gap-4 border-3 rounded-1 mb-2 p-4 w-full">
            <div class="col-start-1 col-end-6" :style="hiddenText">{{ toDo.title }}</div>
            <div class="col-start-7">
                <div class="grid grid-cols-2 text-sm">
                    <div>CreatedAt</div>
                    <div> {{ String(toDo.created_at).slice(0, 10) }}</div>
                </div>
                <div class="grid grid-cols-2 text-sm">
                    <div>DeadLine</div>
                    <div>{{ checkDeadLine(toDo.deadline) }}</div>
                </div>
            </div>            
        </div>
        <div class="border border-3 border-primary rounded-1 mb-2 p-4">
            <div class="col-8">{{ toDo.description !== null ? toDo.description : "상세내용을 적어주세요."}}</div>            
        </div>
        <div class="text-center">
            <button type="button" class="btn btn-warning mr-2" @click="complete(toDo.id)">완료</button>            
            <button type="button" class="btn btn-primary" @click="redirectToDateSet(toDo.id)">상세설정</button>         
        </div>                                            
    </div>
</template>

<script>
export default {
    setup: () => ({
        greeting: 'Hello World from Vue 3!'
    }),

    props: {
        toDoId: {
            type: Number,
            required: true,
        }
    },

    data() {
        return {
            id: this.toDoId,
            toDo: [],
            hiddenText: {
                overflow: 'hidden',
                textOverflow: 'ellipsis',
                whiteSpace: 'nowrap'
            }            
        }
    },

    created() {
        axios.get('../../api/todo/Showdetail', {
            params: {
                id: this.id
            }
        }).then(res => {
            this.toDo = res.data.todo_detail;
            console.log(res);
        });
    },

    methods: {
        redirectToDateSet(id) {
            window.location.href = `/todo/setDetail/${id}`;
        },

        checkDeadLine(deadline) {
            return deadline !== null ? deadline : "undefined";
        },

        complete(id) {
          axios.get('../../api/todo/complete', {
              params: {
                  ToDoId: id
              }
          }).then(res => {
                console.log(res);
                // this.ToDoList = res.data.list_arr;             
        });
        window.location.href = '/';
      },

      redirectToHome() {
            window.location.href = '/';
        }
    }
}
</script>