<template>
    <div>
        <h1>{{ greeting }}</h1>
    </div>    
</template>
<script>

export default {
    setup: () => ({
        greeting: 'This is Funking Test!'
    }),

    created() {
        axios.get('/home').then(res => {
                console.log(res);
                // this.users = res.data.users;
        }).catch(error => {
            console.log(error)
        });
    },
}
</script>