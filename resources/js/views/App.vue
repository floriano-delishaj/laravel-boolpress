<template>
    <div>
        <TheNavBar />
        <router-view />
    </div>
</template>

<script>
import TheNavBar from "../components/TheNavBar.vue";
import axios from "axios";

export default {
    components: {
        TheNavBar,
    },
    data() {
        return {
            user: null,
        }
    },
    methods: {
        async fetchUser() {
            try {
                const res = await axios.get('/api/user')
                this.user = res.data;
                // All'interno del localStorage, salviamo i dettagli dell'utente
                localStorage.setItem('user', JSON.stringify(res.data));
                // Per comunicare in tempo reale che l'utente loggato è cambiato,
                // lanciamo un evento custom su window
                window.dispatchEvent(new CustomEvent('storedUserChanged'))
            } catch (error) {
                // Entriamo nel catch SOLO se l'utente non è loggato e il server ci ritorna
                // un codice diverso da 200. Se non siamo loggati abbiamo un 401.

                // Nel caso di errore, cancelliamo i dettagli dell'utente dal localStorage
                localStorage.removeItem('user')
                // Per comunicare in tempo reale che l'utente loggato è cambiato,
                // lanciamo un evento custom su window
                window.dispatchEvent(new CustomEvent('storedUserChanged'))
            }
        }
    },
    mounted() {

        this.fetchUser()
    }
};
</script>

<style>

</style>
