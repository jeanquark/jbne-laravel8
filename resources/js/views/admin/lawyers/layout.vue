<template>
    <div>
        <h1>Lawyers</h1>
        <router-link :to="{ name: 'adminIndex' }">Admin</router-link>
        <router-link :to="{ name: 'adminLawyersIndex' }">Avocats</router-link>
        <router-link :to="{ name: 'adminLawyersCreate' }">Créer</router-link>
        <router-link :to="{ name: 'adminLawyersEdit', params: { id: 1 } }">Editer</router-link>
        <router-view></router-view>
    </div>
</template>

<script>
export default {
    name: 'AdminLawyersLayout'
}
</script>

<style scoped>

</style>