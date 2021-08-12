<template>
    <div            
        @click="onClickToDetail(toDo.id)"
        class="text-center border-2 rounded hover:bg-gray-400 mb-1"     
    >
        {{ toDo.title }}
    </div>  
</template>

<script>
export default {
    props: {
        toDo: {
            type:Number,
            required: true,
        }
    },

    methods: {
        onClickToDetail(id) {
            this.$emit('onClickToDetail', id);
        }
    },
} 
</script>