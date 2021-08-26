<template>
    <!-- <div v-for="(num, i) in new Array(lastPage)" :key="i">
        <button type="button" class="btn btn-warning"> {{ i }} </button>  
    </div> -->
    <div>
        <nav aria-label="Page navigation example">
            <ul class="pagination justify-content-end">
                <li class="page-item">
                    <a class="page-link" @click="changePage(ToDoList.current_page - 1)">Previous</a>
                </li>
                <li class="page-item" v-for="(num, i) in new Array(lastPage)" :key="i"><a class="page-link" @click="changePage(i + 1)">{{ i + 1 }}</a></li>
                <li class="page-item">
                    <a class="page-link" @click="changePage(ToDoList.current_page + 1)">Next</a>
                </li>
            </ul>
        </nav>
    </div>
</template>

<script>
export default {
    data() {
        return {
            ToDoList: [],
        }
    },

    watch: {
        currentPage( NewVal, OldVal ) {
            this.$emit('pageNumber', NewVal);
        }
    },

    created() {
        //페이지를 불러올 때, axios를 통해서 DB에서 ToDo Data를 초기화
        axios.get('api/todo').then(res => {   
            console.log(res);                     
            this.ToDoList = res.data.list_arr;
        });
    },

    computed: {
        currentPage: {
            get() {
                return this.ToDoList.current_page;
            }
        },

        lastPage: {
            get() {
                return this.ToDoList.last_page;
            }
        }
    },

    methods: {
        changePage(val) {
            if ( val <= 0 || val > this.lastPage ) {
                return;
            }
            this.ToDoList.current_page = val;            
        }
    }
}
</script>