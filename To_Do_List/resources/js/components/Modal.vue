<template>
    <div class="white-bg">
        <div>
            <input class="border-4 border-pink-400 bg-gray-400 w-full p-2 mb-2" type="text" v-model="groupName" placeholder="グループ名を書いてください。">
        </div>
        <div class="text-center">
            <button type="button" class="btn btn-primary mr-2" @click="createGroup">作り</button>
            <button type="button" class="btn btn-warning" @click="closeModal">閉める</button>
        </div>        
    </div>
</template>

<script>
export default {
    data() {
        return {
            groupName: '',
        }
    },

    methods: {
        //modal창에서 group생성할 때 실행되는 함수
        createGroup() {            
            axios.post('api/group/create', {
                group_name: this.groupName
            }).then(res => {                             
                this.closeModal();
                this.addGroup(res.data.Group);
                this.groupName = '';
            });
        },

        closeModal() {
            this.$emit('showModal');
        },

        addGroup(group) {
            this.$emit('addGroup', group)
        }
    }
}
</script>