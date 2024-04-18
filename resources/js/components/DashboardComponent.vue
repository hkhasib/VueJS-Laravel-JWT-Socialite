
<template>
    <div class="row justify-content-md-center">
        <div class="col-md-6">
            <h1>Welcome: {{data.name}} to the Dashboard</h1>

            <qrcode-vue :value="QRValue" :size="300" level="H" /><br>
<h2>Link</h2>
            <a :href="QRValue"> {{QRValue}}</a>
        </div>
    </div>
</template>
<script>
import QrcodeVue from "qrcode.vue";
export default {
    components: {
        QrcodeVue,
    },
    data(){
        return{
            'data': '',
            'QRValue': '',

        }
    },
    mounted(){
        this.$nextTick(this.submitForm);
    },
    methods: {
        async submitForm(){

            axios({
                method: 'post',
                headers: {Authorization: 'bearer'+ localStorage.getItem('token')},
                url: 'http://127.0.0.1:8000/api/auth/profile/',
            }).then((response)=>this.data=response.data.data)
                .then(()=>this.QRValue='http://127.0.0.1:8000/user/'+this.data.id)
                .then((response)=>console.log(response)).catch((error)=>{
                console.log(error);
                if (error.response.status===401){
                    this.error=true;
                    this.error_message=error.response.data.error;
                    Swal.fire("Error!", error.response.data.error, "error");
                }
                console.log(error.response);
            });

            console.log(this.array);

        }
    }
}
</script>
