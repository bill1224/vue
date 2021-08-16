<template>
    <div>
        <div class="black-bg" v-if="modal_is_state">
            <div class="white-bg">
                ㅇㅇㅇㅇㅇ
            <button @click="modal_is_state=false">닫기</button>
            </div>
        </div>

        <div class="mb-2 border-b-2 p-2" @click="changeCategory(1004)">
            전체
        </div>
        <div class="mb-2 p-2" @click="changeCategory(1141)">
            중요
        </div>
        <div class="form-floating">
            <select class="form-select" id="floatingSelect" aria-label="Floating label select example" v-model="categoryNum">
                <template v-for="Group in groupArr" :key="Group.id">            
                    <option :value="Group.id">{{ Group.group_name }}</option>
                </template>                       
            </select>
            <label for="floatingSelect">Group with selects</label>
        </div>
        <div class="flex border-b-2 p-2 hover:bg-gray-500" @click="test">
            <div class="flex-initial">
                <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 512 512"><g fill="#1138f7"><circle cx="256" cy="256" r="236.17"/><path d="M256 512C114.853 512 0 397.167 0 256 0 114.853 114.853 0 256 0c141.167 0 256 114.853 256 256 0 141.167-114.833 256-256 256zm0-472.341C136.705 39.659 39.659 136.705 39.659 256S136.705 472.341 256 472.341 472.341 375.275 472.341 256c0-119.295-97.046-216.341-216.341-216.341z"/></g><g fill="#fff"><path d="M256 373.193c-10.946 0-19.83-8.864-19.83-19.83V155.067c0-10.946 8.884-19.83 19.83-19.83 10.946 0 19.83 8.884 19.83 19.83v198.296c0 10.966-8.884 19.83-19.83 19.83z"/><path d="M355.148 274.045H156.852c-10.946 0-19.83-8.884-19.83-19.83 0-10.946 8.884-19.83 19.83-19.83h198.296c10.966 0 19.83 8.884 19.83 19.83 0 10.946-8.864 19.83-19.83 19.83z"/></g></svg>                
            </div>            
            <div class="ml-2">그룹생성</div> 
        </div>
    </div>
</template>

<script>
export default {
    props: {
        groupArr: {
            type:Object,
        }
    },
    
    data() {
        return {     
            categoryNum: '',
            text: '변경전',
            modal_is_state: false,
        }
    },

    watch: {
        categoryNum: function (newVal, oldVal) {
            this.$emit("getCategoryNumber", newVal);
        }
    },

    // created() {
    //     axios.get('api/getGroup').then(res => {
    //         this.Groups = res.data.Groups;
    //     })
    // },

    methods: {
        changeCategory(Num) {
            this.categoryNum = Num
        },

        test() {
            console.log("눌렀당");
        }
    },
}
</script>

<style scoped>
    .black-bg {
        width: 100%; height: 100%;
        background: rgba(0,0,0,0.5); 
        position: fixed; padding: 20px;
    }
    .white-bg {
        width: 100%; background: white;
        border-radius: 8px;
        padding: 20px;
    }
</style>