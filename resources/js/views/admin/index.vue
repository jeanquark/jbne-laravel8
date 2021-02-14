<template>
    <div>
        <h1>Bienvenue sur la page d'administration du JBNE</h1>
        <p>
            <a href="/">Retour au site</a> |
            <!-- <router-link :to="{ name: 'adminUsersIndex' }">Users</router-link> | -->
            <router-link :to="{ name: 'adminLawyersIndex' }">Lawyers</router-link>
        </p>
    </div>
</template>

<script>
export default {
    name: 'AdminIndex'
}
</script>

<style scoped>

</style>