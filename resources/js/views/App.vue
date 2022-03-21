<template>
    <div>
        <TheNavBar />
        <TheMain @fetchPosts="fetchPosts" :pagination="pagination" :posts="posts"/>
    </div>
</template>

<script>
import axios from 'axios';

import TheNavBar from "../components/TheNavBar.vue";
import TheMain from "../components/TheMain";

export default {
    data() {
        return {
            posts: [],
            pagination: {},
        }
    },
    components: {
        TheMain,
        TheNavBar,
    },
    methods: {
        async fetchPosts(page = 1) {
            if (page < 1)
            {
                page = 1;
            }

            if (page > this.pagination.last_page)
            {
                page = this.pagination.last_page;
            }

            const res = await axios.get('/api/posts?page=' + page);
            this.pagination = res.data;
            this.posts = res.data.data;
        }
    },
    mounted() {
        this.fetchPosts();
    }
};
</script>

<style>

</style>
