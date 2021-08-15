<template>
    <div class="mb-2">
        일반
    </div>
    <div class="mb-2">
        중요
    </div>
    <!-- <div 
        v-for="Group in groupArr" 
        :key="Group.id"
        class="mb-2"
    >
        {{ Group.group_name }}
    </div> -->

    <div class="form-floating">
        <select class="form-select" id="floatingSelect" aria-label="Floating label select example" v-model="value">
            <template v-for="Group in groupArr" :key="Group.id">            
                <option :value="Group.id">{{ Group.group_name }}</option>
            </template>
            <!-- <option selected>Click this select menu</option> -->            
        </select>
        <label for="floatingSelect">Group with selects</label>
    </div>
    <div>
        {{ value }}
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
            value: '',   
        }
    },

    // created() {
    //     axios.get('api/getGroup').then(res => {
    //         this.Groups = res.data.Groups;
    //     })
    // }
}
</script>