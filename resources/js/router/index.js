import {createRouter, createWebHistory} from "vue-router";

import LoginComponent from "@/components/loginComponent.vue";
import ExampleComponent from "@/components/ExampleComponent.vue";
import RegComponent from "@/components/RegComponent.vue";
import DashboardComponent from "@/components/DashboardComponent.vue";
import UserComponent from "@/components/UserComponent.vue";
import TwitterAuthHandleComponent from "@/components/TwitterAuthHandleComponent.vue";
import GoogleAuthHandleComponent from "@/components/GoogleAuthHandleComponent.vue";

const routes =[
    {
        path: '/',
        component: ExampleComponent,
        name: 'home'
    },
    {
        path: '/login',
        name: 'login',
        component: LoginComponent
    },
    {
        path: '/register',
        name: 'register',
        component: RegComponent
    },
    {
        path: '/auth/twitter/call-back',
        name: 'twitterHandle',
        component: TwitterAuthHandleComponent
    },
    {
        path: '/auth/google/call-back',
        name: 'googleHandle',
        component: GoogleAuthHandleComponent
    },
    {
        path: '/dashboard',
        name: 'dashboard',
        component: DashboardComponent,
        meta: {requiresAuth: true}
    },
    {
        path: '/user/:id',
        name: 'user',
        component: UserComponent,
        meta: {requiresAuth: true}
    },
]

const router = createRouter({
    history: createWebHistory(),
    routes
})

router.beforeEach((to, from)=>{
if(to.meta.requiresAuth && !localStorage.getItem('token')){
    return {
        name: 'login'
    }
}

})
export default router;
