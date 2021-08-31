<template>    
    <!-- Modal Popup -->
    <div class="black-bg" v-if="modal_is_state">>
        <Modal @show-modal="showModal" @add-group="addGroup"/>
    </div>
    <!-- header -->
    <Header />

    <div class="flex h-full mt-16 bg-gray-700">
        <!-- Navbar Component -->
        <div class="w-1/5 border-r-2 border-solid border-gray-600 px-2">
            <Navbar :group-arr="Groups" @get-category-status="getcategoryStatus" @show-modal="showModal"/>
        </div>
        
        <!-- 메인 화면 -->
        <template v-if="ToDoId === ''">
            <div class="w-4/5 flex flex-col px-16">
                <!-- Nav에서 category가 변경될 때, categoryStatus값을 통해 바인딩받아서, Title에 해당하는 부분이 변경되도록 , 처음에는 All로 초기화되어 있음 -->
                <div class="text-center mb-4"><span class="fs-1"> {{ categoryStatus }} </span></div>
                <!-- 해야할 일, 완료한 일, 전체의 상태에 따라서, 몇 개의 ToDoList 값이 있는지를 보여주기 위함 -->
                <div v-if="currentState === 0">해야할 일 : {{ total }} </div>
                <div v-else-if="currentState === 1">완료한 일 : {{ total }}</div>            

                <!-- important일 때와, pattern일 경우에는 따로 글을 그곳에서 작성하는 것이 아닌, 따로 별표시나, 상세설정에서 바꾸는 것이기 때문에 text form은 보이지 않도록한다.  -->
                <!-- <div class="flex-initial mt-2" v-if="categoryStatus !== 'important' && patternArr.indexOf(this.categoryStatus) < 0 && currentState === 0">
                    <input 
                        type="text" 
                        v-model="title" 
                        @keyup.enter="submit" 
                        placeholder="ToDoを書いてください。" 
                        class="mb-4  border-4 border-pink-400 w-full p-2 text-black"
                        autofocus
                    >
                </div> -->
                <InputText :category-status="categoryStatus" :current-state="currentState" @get-result="submitText"/>

                <!-- template v-for를 이용해서, DB에서 받아온 ToDoList를 computed에서 NotCompleteToDoList로 가공한뒤에 
                ToDoView 컴포넌트로 보냄  -->
                <div class="flex-none">
                    <template v-for="ToDo in ToDoList" :key="ToDo.id">
                        <ToDoView :to-do="ToDo" @onClickToDetail="onClickRedirect" @re-get-list="reGetList"/>                                  
                    </template>
                </div>            

                <!-- Paginate -->
                <div>
                    <pagination :page-list="pageList" @page-number="getPageNumber"/>
                </div>

                <!-- 해야할 일, 완료한 일, 전체의 상태를 변경할 수 있는 버튼 -->
                <div class="text-center mt-2">
                    <button type="button" class="btn btn-warning" @click="changeState(0)">進行</button>            
                    <button type="button" class="btn btn-primary mx-2" @click="changeState(1)">完了</button>                      
                </div> 
            </div>
        </template>

        <template v-else-if="showDetail">
            <SetDetail :to-do-id="ToDoId" @redirect-back-detail="onClickRedirect"/>
        </template>

        <!-- To Do Detail 화면 -->
        <template v-else>
            <ToDoDetail :to-do-id="ToDoId" @show-set-detail="ShowSetDetail"/>
        </template>

        <div>
            {{ test }}dfsdfsd
        </div>
    </div>
</template>

<script>
import Header from "./Header";
import Navbar from "./Navbar";
import ToDoView from './ToDoView';
import pagination from './pagination';
import Modal from './Modal';
import ToDoDetail from './ToDoDetail';
import SetDetail from './SetDetail';
import InputText from './InputText';

export default {
    props: ['test'], 

    components: {
        ToDoView, //ToDO List를 보여주는 component
        Header, //Heeader component
        Navbar, //Nav component
        pagination, //pagination Component
        Modal, 
        ToDoDetail,
        SetDetail,
        InputText,
    },

    data() {
        return {            
            ToDoList: [], // ToDo Data를 저장하기 위함
            title: '', // ToDo 생성할 때, text form 값과 v-model로 바인딩
            currentState: 0, // 해야할 일, 완료한 일, 전체의 상태를 나타내기 위함
            Groups: [], //그룹 목록을 저장하기 위함
            categoryStatus: "All", // Nav에서 category변경값을 저장하기 위함, 처음에는 All로 초기화
            modal_is_state: false, // 모달창을 상태를 위함
            groupName: '',         
            pageList: '', 
            total: '',  // ToDo List 개수를 저장해서 알려주기 위함            
            ToDoId: '',
            showDetail: false,
        }
    },

    watch: {
        currentState(NewVal, OldVal) {
            this.getResult(1, this.categoryStatus);
        },

        categoryStatus(NewVal, OldVal) {            
            this.getResult(1, NewVal);
        },
    },
    
    created() {
        //페이지를 불러올 때, axios를 통해서 DB에서 Group Data를 초기화
        axios.get('api/group').then(res => {
            this.Groups = res.data.Groups;            
        });     

        //페이지를 불러올 때, axios를 통해서 DB에서 ToDo Data를 초기화
        this.getResult();
    },

    methods:{
        //모든 data를 가져올 때 기반이되는 함수 
        getResult(pageNum = 1, categoryStatus = "All") {
            axios.get('api/todo?page=' + pageNum, {
                params: {
                    currentState: this.currentState,
                    categoryStatus: categoryStatus
                }
            }).then(res => {                       
                this.ToDoList = res.data.list_arr.data;
                this.pageList = res.data.list_arr;
                this.lastPage = res.data.list_arr.last_page;
                this.total = res.data.list_arr.total; 
            });
        },

        //ToDoView에서 해당  ToDo가 클릭될 때 emit을 통해 해당 함수를 실행
        // location을 통해서 해당 ToDo의 id값을 URL에 포함시켜 URL변경
        onClickRedirect(id) {            
            this.ToDoId = id;
            this.showDetail = false;            
        },

        submitText(lastPage, categoryStatus) {
            this.getResult(lastPage, categoryStatus);
        },

        //해야할 일, 완료한 일, 전체의 버튼이 눌릴 때, 실행되는 함수
        //눌릴 때마다 해당 value값으로 변경
        changeState(value) {
            this.currentState = value;
            return;
        },

        //ToDoNav에서 Catagory가 변경될 경우 emit을 통해 함수를 수행
        //category value를 받아옴 
        getcategoryStatus(val) {
            this.categoryStatus = val;
            this.currentState = 0;
            this.ToDoId = '';
            this.showDetail = false;
        },

        //ToDoView에서 중요표시를 눌렀을 때, emit을 통해서, 중요도순으로 다시 불러옴으로써 상위로 올라가도록 
        reGetList() {
            this.getResult(1, this.categoryStatus);
        },
        
        //modal창에서 group생성할 때 실행되는 함수
        addGroup(group) {
            this.Groups.push(group);

        },

        //ToDoNav에서 group생성을 누르면, emit을 통해서 해당 함수가 실행된다.
        //modal is status 값을 true로 변경시켜 v-if의 해당 태그가 보여지면서 모달창이 생기게됨
        showModal() {          
            this.modal_is_state = !this.modal_is_state
        },      

        // paginate components에서 emit을 통해 실행된느 함수
        // currentPage number을 받아와서 해당 페이지에 맞는 data를 가져오도록 
        getPageNumber(pageNum) {
            this.getResult(pageNum, this.categoryStatus);
        },

        ShowSetDetail(id) {
            this.ToDoId = id;
            this.showDetail = true;
        }
    }
}
</script>

// scoped는 해당 component에서만 동작하도록 해주는 명령어
// modal에 관련된 style설정이다.
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