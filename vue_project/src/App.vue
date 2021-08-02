<template> 
  <div class="black-bg" v-if="modal_is_state">
    <div class="white-bg">
      <h4>상세페이지임</h4>
      <p>상세페이지 내용임</p>
      <button @click="modal_is_state=false">닫기</button>
    </div>
  </div>
  <div class="menu">
    <a v-for="menu in menus" :key="menu">
      {{ menu }}
    </a>
  </div>  
  <!-- <div>
    <img :src="products[0].image" alt="디지니랜드" class="room-img">
    <h4 @click="modal_is_state=true">{{ products[0].title }}</h4>
    <p>가격 : {{ products[0].price }}만원</p>
    <button @click="increase(0)">허위매물신고</button> <span>신고수 : {{ report_num[0] }} </span>
  </div>
  <div>
    <img src="./assets/만화카페.jpg" alt="만화카페" class="room-img">
    <h4>{{ products[1] }}</h4>
    <p>60 만원</p>
    <button @click="increase(1)">허위매물신고</button> <span>신고수 : {{ report_num[1] }} </span>
  </div>
  <div>
    <img src="./assets/패밀리.jpg" alt="패밀리" class="room-img">
    <h4>{{ products[2] }}</h4>
    <p>70 만원</p>
    <button @click="increase(2)">허위매물신고</button> <span>신고수 : {{ report_num[2] }} </span>
  </div>  -->

  <div v-for="(product, i) in products" :key="i">    
    <img :src="product.image" class="room-img">
    <h4>{{ product.title }}</h4>
    <p>{{ product.price }}</p>
    <p>{{ product.content }}</p>
    <button @click="increase(i)">허위매물신고</button> <span>신고수 : {{ report_num[i] }} </span>
  </div>   
</template>

<script>
import data from './oneroom.js';

export default {
  name: 'App',
  data(){
    return {       
      modal_is_state: false,
      report_num : [0, 0, 0, 0, 0, 0],
      menus : ['Home', 'Shop', 'About'],
      products : data,  
    }
  },
  methods : {
    increase(i){
      this.report_num[i] += 1;
    }
  },

  components: {
    
  }
}
</script>

<style>
body {
  margin :0
}
div {
  box-sizing:border-box;
}
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
#app {
  font-family: Avenir, Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;  
}

.menu {
  background: darkslateblue;
  padding:15px;
  border-radius: 5px;  
}
.menu a{
  color: white;
  padding: 10px;
}
.room-img{
  width: 50%;
  margin-top:40px;
}
</style>
