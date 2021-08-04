<template>
    <div>
        <h1>Welcome to {{ title }}!</h1>
        <input type="text" v-model="input1" />
        <button @click="getData">Get</button>
        <button @click="setData">Set</button>
    </div>
</template>

<script>
export default {
    data() {
        return {
            title: "초보 개발자", 
            input1: ""           
        };
    },
    methods: {
        getData() {
            //method에서 변수명에 접근할 때에는 this를 붙힌다.
            alert(this.input1);
        },
        setData() {
            this.input1 = "1234"
        }
    }
};
</script>