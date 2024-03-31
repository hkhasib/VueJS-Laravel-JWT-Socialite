<template>
    <h1>Please Wait .....</h1>
</template>
<script>

export default {
    mounted() {
        let code = window.location.search;

        axios.get('http://127.0.0.1:8000/twitter/call-back-server'+code)
            .then((response)=>{
                localStorage.setItem('token',response.data.access_token);
            })
            .then(()=>{
                this.$router.push({name:'dashboard'})
            });

    }
}
</script>
