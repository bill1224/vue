require('./bootstrap');

import { createApp } from 'vue'
import ToDoList from './components/ToDoList.vue';

const app = createApp({});
app.component('to-do-list', ToDoList)
    .mount('#app');
