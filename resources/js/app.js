require("./bootstrap");

import Vue from "vue";

//Main pages
import App from "./views/App";
import router from "./router/index";
import store from "./store/index";
import vuetify from "./vuetify";
import { mapState } from "vuex";
import axios from "axios";

Vue.component(
    "example-component",
    require("./components/ExampleComponent.vue").default
);
Vue.component(
    "login-component",
    require("./components/LoginComponent.vue").default
);

const app = new Vue({
    el: "#app",
    router,
    store,
    vuetify,
    components: { App },
    created() {
        console.log("created()");
        // this.$store.commit("INCREMENT");
        console.log("count: ", this.count);
    },
    mounted() {},
    data() {
        return {
            // count: 0
        };
    },
    computed: {
        // ...mapState({
        //     count: state => state.count
        // })
    },
    methods: {
        async register() {
            try {
                console.log('register')
                const data = await axios.post("/register", {
                    name: "John Doe",
                    email: "john2.doe@example.com",
                    password: "pingpong",
                    password_confirmation: "pingpong"
                })
                console.log('data: ', data)
            } catch (error) {
                console.log('error: ', error)
            }
        },
        async login() {
            try {
                console.log("login");
                const response = await axios.get("/sanctum/csrf-cookie");
                console.log("response: ", response);
                // Login...
                const response2 = await axios.post("/login", {
                    email: "lawyer@example.com",
                    password: "password"
                });
                console.log("response2: ", response2);
            } catch (error) {
                console.log("error: ", error);
            }
        },
        async logout() {
            try {
                console.log("logout");
                // const response = $user = request()->user()
                const response = await axios.post("/logout");
                console.log("response: ", response);
                location.href = "/";
            } catch (error) {
                console.log("error: ", error);
            }
        },
        async forgotPassword() {
            try {
                console.log("forgotPassword");
                const data = await axios.post("/forgot-password", {
                    email: "lawyer@example.com"
                });
                console.log("data: ", data);
            } catch (error) {
                console.log("error: ", error);
            }
        },
        async getUser() {
            try {
                const user = await axios.get("/api/user");
                console.log("user: ", user);
            } catch (error) {
                console.log("error: ", error);
            }
        },
        incrementCounter() {
            console.log("incrementCounter");
            // this.$store.commit("INCREMENT");
        }
    }
});
