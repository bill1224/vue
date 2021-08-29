<template>
    <div>
        <nav aria-label="Page navigation example">
            <ul class="pagination justify-content-end">
                <li class="page-item">
                    <a class="page-link" @click="changePage(pageList.current_page - 1)">Previous</a>
                </li>
                <li class="page-item" v-for="(num, i) in new Array(lastPage)" :key="i"><a class="page-link" @click="changePage(i + 1)">{{ i + 1 }}</a></li>
                <li class="page-item">
                    <a class="page-link" @click="changePage(pageList.current_page + 1)">Next</a>
                </li>
            </ul>
        </nav>
    </div>
</template>

<script>
export default {
    props: ['pageList'],

    // data() {
    //     return {
    //         ToDoList: [],
    //     }
    // },

    watch: {
        // 현재 선택된 페이지 번호를 부모 컴포넌트로 보내서, axios할 때, 가져오고 데이터의 페이지부분을 지정해준다. 
        currentPage( NewVal, OldVal ) {
            this.$emit('pageNumber', NewVal);
        }
    },

    computed: {
        currentPage: {
            get() {
                return this.pageList.current_page;
            }
        },

        lastPage: {
            get() {
                return this.pageList.last_page;
            }
        }
    },

    methods: {
        changePage(val) {
            // next, Previous버튼을 눌렀을 때, 최소/최대 페이지를 넘었을 경우에는 아무런 동작 하지 않도록
            if ( val <= 0 || val > this.lastPage ) {
                return;
            }
            this.pageList.current_page = val;            
        }
    }
}
</script>