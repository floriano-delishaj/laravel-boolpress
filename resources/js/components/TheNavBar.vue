<template>
    <div>

            <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
                <div class="container">
                    <router-link class="navbar-brand" to="/home">Boolpress</router-link>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">
                        <ul class="navbar-nav mb-2 mb-lg-0">
                            <li class="nav-item"
                                v-for="route in routes"
                                :key="route.path">
                                <router-link class="nav-link" :to="route.path">
                                    {{ route.meta.nameLinkNav }}
                                </router-link>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="/login">Admin</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
    </div>
</template>

<script>
import axios from 'axios'

export default {
    data() {
        return {
            routes: [],
            user: null,
        }
    },
    methods: {
        async fetchUser() {
            const res = await axios.get('api/user')
            this.user = res.data;
        }
    },
    mounted() {
        this.routes = this.$router.getRoutes().filter((route) => route.meta.nameLinkNav);
        this.fetchUser()
    }
}
</script>

<style lang="scss" scoped>

</style>
