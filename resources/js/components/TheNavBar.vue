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
                            <li class="nav-item" v-if="!user">
                                <a class="nav-link" href="/login">Login</a>
                                <a class="nav-link" href="/register">Register</a>
                            </li>
                            <li class="nav-item" v-else>
                                <a class="nav-link" href="/admin">{{ user.name }}</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
    </div>
</template>

<script>

export default {
    data() {
        return {
            routes: [],
            user: null,
        }
    },
    methods: {
        getStoredUser() {
            const storedUser = localStorage.getItem('user')

            if(storedUser) {
                this.user = JSON.parse(storedUser);
            } else {
                this.user = null;
            }
        }
    },
    mounted() {
        this.routes = this.$router.getRoutes().filter((route) => route.meta.nameLinkNav);

       this.getStoredUser();

        window.addEventListener('storedUserChanged', () => {
            this.getStoredUser();
        })
    },
}
</script>

<style lang="scss" scoped>

</style>
