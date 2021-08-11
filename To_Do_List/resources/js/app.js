require('./bootstrap');

import { createApp } from 'vue'
import TestFile from './components/TestFile.vue';

const app = createApp({});
app.component('test-file', TestFile)
    .mount('#app');
