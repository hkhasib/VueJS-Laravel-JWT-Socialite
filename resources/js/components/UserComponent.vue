
<template>
    <div class="row justify-content-md-center">
        <div class="col-md-6">
            <h1>Welcome: {{data.name}} to the Dashboard. User id: {{$route.params.id}}</h1>
<br>
            <div id="element-to-convert">
                <qrcode-vue :value="QRValue" :size="300" level="H" />
                <h3>User ID: {{data.id}}</h3>
                <h3>Name: {{data.name}}</h3>
                <h3>Email: {{data.email}}</h3>
            </div>
            <hr>
            <button @click="exportToPDF" class="btn btn-success">Export to PDF</button>
        </div>
    </div>
</template>
<script>
import html2pdf from "html2pdf.js/src";
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
        exportToPDF() {
            html2pdf(document.getElementById("element-to-convert"), {
                margin: 1,
                filename: "user-details.pdf",
            });
    },
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
