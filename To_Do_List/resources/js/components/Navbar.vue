<template>
    <div>
        <div class="mb-2 border-b-2 p-2" @click="changeCategory(1004)">
            일반
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
        }
    },
}
</script>