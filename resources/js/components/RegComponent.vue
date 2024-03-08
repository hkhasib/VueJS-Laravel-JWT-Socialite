<template>
    <div class="row justify-content-md-center">
        <div class="col-md-6">
            <form @submit.prevent="submitForm">

                <div class="form-group">
                    <label for="exampleInputEmail1">Name</label>
                    <input v-model="name" required name="name" type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter Username">

                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Email</label>
                    <input v-model="email" required name="email" type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter Username">

                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">Password</label>
                    <input v-model="password" required name="password" type="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
                </div>
                <div class="form-group form-check">
                    <input type="checkbox" class="form-check-input" id="exampleCheck1">
                    <label class="form-check-label" for="exampleCheck1">Check me out</label>
                </div>
                <button type="submit" class="btn btn-primary">Register</button>
            </form>
            <br>
            <button @click="tryWithGoogle"  class="btn btn-danger" style="margin-right: 5px">Google</button>
            <button @click="tryWithTwitter" class="btn btn-dark">Twitter</button>
        </div>
    </div>
</template>

<script>
import Swal from "sweetalert2";

export default {
    data(){
        return{
            name: '',
            email: '',
            message: '',
            password:'',
            status: '',
            error: false
        }
    },
    mounted() {

    },
    methods:{
        async submitForm(){

            axios({
                method: 'post',
                url: 'http://127.0.0.1:8000/api/auth/register/',
                data: {
                    name: this.name,
                    email: this.email,
                    password: this.password,
                }
            }).then((response)=>localStorage.setItem('token',response.data.access_token))
                .then(()=>this.$router.push({name: 'login'})).catch((error)=>{
                console.log(error);
                if (error.response.status===401){
                    this.error=true;
                    this.error_message=error.response.data.error;
                    Swal.fire("Error!", error.response.data.error, "error");
                }
                console.log(error.response.data);
            });


        },

        tryWithGoogle(){
            axios({
                method: 'get',
                url: 'http://127.0.0.1:8000/try-google'
            }).then((response)=>{
                window.location.href = response.data.url
            })
        },
        tryWithTwitter(){
            axios({
                method: 'get',
                url: 'http://127.0.0.1:8000/try-twitter'
            }).then((response)=>{
                window.location.href = response.data.url
            })
        }
    }
}
</script>
