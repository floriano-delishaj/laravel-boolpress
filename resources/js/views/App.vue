<template>
    <div>
        <TheNavBar />
        <router-view />
    </div>
</template>

<script>
import TheNavBar from "../components/TheNavBar.vue";


export default {
    components: {
        TheNavBar,
    },
};
</script>

<style>

</style>
