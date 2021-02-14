<template>
    <div>
        <p>
            <router-link :to="{ name: 'adminIndex' }">Admin</router-link> |
            <router-link :to="{ name: 'adminLawyers' }">Lawyers</router-link> |
            <router-link :to="{ name: 'adminUsersCreate' }">Create User</router-link> |
            <router-link :to="{ name: 'adminUsersEdit' }">Edit User</router-link>
        </p>
        <router-view></router-view>
        <!-- <v-btn elevation="2" color="pink">Click me</v-btn> -->
        
    </div>
</template>

<script>
export default {
    name: "AdminUsersIndex",
    data() {
        return {
        };
    }
};
</script>

<style scoped></style>
