<template>
    <div>
        <h1>Welcome to {{ title }}!</h1>
        <input type="text" v-model="input1" />
        <button @click="getData">Get</button>
        <button @click="setData">Set</button>

        <select class="form-control" v-model="region" @change="changeRegion">
            <option v-for="(d,i) in obtions" :key="i" :value="d.v">{{ d.t }}</option>
        </select>
        {{ region }}
        <!-- v-if 와 v-show의 기능자체는 똑같다. 하지만, 차이점은? 
        v-if는 조건에 만족하지 않으면, 렌더링조차 하지 않는다. 
        v-show는 조건에 맞지 않더라도, 일단 렌더링은 한다. 
        만약에 이 엘리먼트가 자주 변경이 된다면, v-if로 했을때 렌더링 했다가 삭제했다가 
        반복할 수 있기 때문에 불피요한 리소스가 생길 수 있다. 
        그래서 그러한 상황에 따라서 상황하면 된다.  -->
        <table class="table table-bordered" v-show="tableshow">
            <tr v-for="(d,i) in obtions" :key="i">
                <td>{{ d.v }}</td>
                <td>{{ d.t }}</td>
            </tr>
        </table>
    </div>
</template>

<script>
export default {
    data() {
        return {
            title: "초보 개발자", 
            input1: "" ,
            obtions: [
                {v:"S", t:"Seoul"},
                {v:"J", t:"Jeju"},
                {v:"B", t:"Busan"}
            ],
            region: "J", 
            tableshow: true       
        };
    },
    //특정 데이터를 항상 모디터링하다가, 변경이되면 특정 함수를 실행시킬 수 있도록 할 수 있게 도와준다.
    watch: {
        //data()에서 선언한 변수명과 동일하게 함수명으로 해줘야한다.
        input1() {
            console.log(this.input1);
        }
    },
    methods: {
        getData() {
            //method에서 변수명에 접근할 때에는 this를 붙힌다.
            alert(this.input1);
        },
        setData() {
            this.input1 = "1234"
        },
        changeRegion() {
            alert(this.region);
        }
    },
    beforeCreate() {

    },
    create() {

    },
    beforeMount() {

    },
    mounted() {

    },
    beforeUpdate(){

    },
    updated(){

    },
    beforeDestory(){

    },
    destoryed(){

    }
};
</script>