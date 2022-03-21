<template>
    <div class="container">
        <h1>{{errorMessage}}</h1>
    </div>
</template>

<script>
export default {
    data() {
        return {
            errorMessage: '',
        }
    },
    mounted() {
        this.errorMessage = this.$route.params.message;
    }
}
</script>

<style lang="scss" scoped>

</style>
