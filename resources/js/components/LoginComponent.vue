<template>
    <div>
        <h1>Login Component</h1>
        <v-btn color="pink" @click="login">Login</v-btn> |
        <button @click="logout">Logout</button><br /><br />
        <button @click="getUser">Get User</button><br />
        User: {{ user }}<br /><br />
        <button @click="getUsers">Get Users</button><br />
        Users: {{ users }}<br /><br />

        <a href="/home">Home</a>
    </div>
</template>

<script>
export default {
    data() {
        return {
            user: null,
            users: null
        };
    },
    methods: {
        async login() {
            try {
                console.log("login");
                const response = await axios.get("/sanctum/csrf-cookie");
                console.log("response: ", response);
                const response2 = await axios.post("/login", {
                    email: "rodriguez.eleanora@example.com",
                    password: "password"
                });
                console.log("response2: ", response2);
                // location.href = "/home";
            } catch (error) {
                console.log("error: ", error);
            }
        },
        login2() {
            console.log("login");
            axios
                .get("/sanctum/csrf-cookie")
                .then(response => {
                    console.log("response: ", response);
                    axios
                        .post("/login", {
                            email: "test@example.com",
                            password: "password"
                        })
                        .then(response => {
                            console.log("response2: ", response);
                            location.href = "/home";
                        })
                        .catch(error => {
                            console.log("error2: ", error);
                        });
                })
                .catch(error => {
                    console.log("error: ", error);
                });
        },
        logout() {
            console.log("logout");
            axios
                .post("/logout")
                .then(response => {
                    console.log("response: ", response);
                    location.href = "/";
                })
                .catch(error => {
                    console.log("error: ", error);
                });
        },
        async getUser() {
            console.log("getUser");
            const { data } = await axios.get("/api/user");
            console.log("data: ", data);
            this.user = data;
        },
        async getUsers() {
            console.log("getUsers");
            const { data } = await axios.get("/api/users");
            console.log("data: ", data);
            this.users = data.users;
        }
    }
};
</script>

<style scoped></style>
