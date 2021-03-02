<template>
    <div>
        <h2>Student protected page</h2>
        <a href="/">Retour au site</a><br />
        Files: {{ files }}
    </div>
</template>

<script>
export default {
    name: "student",
    async created () {
        const data = await this.$store.dispatch('files/fetchFiles')
        this.files = data
    },
    data () {
        return {
            files: []
        }
    }
}
</script>

<style>

</style>