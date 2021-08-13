<template>
    <div class="container">
        <div class="text-center fs-1 mb-4">To Do Detail</div>
        <div class="row border border-3 rounded-1 mb-2 p-4">
            <div class="col">{{ toDoDetail.title }}</div>
            <div class="col">{{ toDoDetail.created_at }}</div>
        </div>
        <div class="row border border-3 border-primary rounded-1 mb-2">
            <div class="col-8">col-8</div>
            <div class="col-4">col-4</div>
        </div>
        <div class="text-center">
            <button type="button" class="btn btn-warning mr-2">Warning</button>            
            <button type="button" class="btn btn-primary" @click="redirectToDateSet(toDoDetail.id)">상세설정</button>         
        </div>                                            
    </div>
</template>

<script>
export default {
    setup: () => ({
        greeting: 'Hello World from Vue 3!'
    }),

    props: {
        toDoDetail: {
            type: Array,
            required: true,
        }
    },

    methods: {
        redirectToDateSet(id) {
            window.location.href = `/todo/setDetail/${id}`;
        }
    }
}
</script>