<template>
    <div>
        <div>
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <a class="navbar-brand" href="#">Navbar</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item active">
                            <router-link to="/" class="nav-link">
                                <span>Home</span>
                            </router-link>
                        </li>
                        <li class="nav-item">
                            <router-link to="/dashboard" class="nav-link">
                                <span>Dashboard</span>
                            </router-link>

                        </li>
                        <li v-if="!authenticatedUser" class="nav-item active">
                            <router-link to="/register" class="nav-link">
                                <span>Register</span>
                            </router-link>
                        </li>
                        <li v-if="!authenticatedUser" class="nav-item">
                            <router-link to="/login" class="nav-link">
                                <span>Login</span>
                            </router-link>

                        </li>
                        <li v-if="authenticatedUser" class="nav-item">
                            <button @click="logout">Logout</button>

                        </li>


                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Dropdown
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="#">Action</a>
                                <a class="dropdown-item" href="#">Another action</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#">Something else here</a>
                            </div>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link disabled" href="#">Disabled</a>
                        </li>
                    </ul>
                    <form class="form-inline my-2 my-lg-0">
                        <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
                        <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
                    </form>
                </div>
            </nav>
        </div>
        <div>
            <router-view/>
        </div>
    </div>


</template>
<script>

import store from "@/store/store.js";
import Swal from "sweetalert2";
export default {
    data(){
      return{
          authenticated: false
      }
    },
    mounted() {

    },
    computed:{
      authenticatedUser(){
          if((this.$route.name==='login'||this.$route.name==='register')
          ||this.$route.name==='home'){
              return false;
          }
          return true;
      }
    },
    methods:{
        logout(){
            axios({
                method: 'post',
                headers: {Authorization: 'bearer'+ localStorage.getItem('token')},
                url: 'http://127.0.0.1:8000/api/auth/logout/',
            }).then((response)=>localStorage.removeItem('token'))
                .then(()=>this.$router.push({name: 'login'})).catch((error)=>{
                console.log(error);
                if (error.response.status===401){
                    this.error=true;
                    this.error_message=error.response.data.error;
                    Swal.fire("Error!", error.response.data.error, "error");
                }
                console.log(error.response.data);
            });
        }
    }
}
</script>
