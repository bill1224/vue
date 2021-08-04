<template>
    <div>
        <!-- <input type="text" v-model="data[$route.params.id].writer" name="ff">
         {{ writer }} -->
    
    </div> 
</template>

<script>
import data from '@/data';

export default {
    name: 'update',
    data() {
        return {
            data: data,
            writer: "",
            title: "",
            contents: ""
        }
    },
}
</script>