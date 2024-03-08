import {createStore} from "vuex";


const store = createStore({
    state:{
        authenticated: false,
        access_token: null,
        user:[]
    }
})

export default store;
