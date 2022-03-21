<template>
    <div class="container mt-5">
        <div class="row row-cols-1 row-cols-md-2 g-4">
            <TheCard v-for="post in posts" :key="post.id" :post="post"/>
        </div>
        <nav aria-label="pagination card" class="my-5">
            <ul class="pagination">
                <li class="page-item">
                    <a :class="['page-link', {disabled: pagination.current_page === 1}]"
                       @click="fetchPosts(prevPage)"
                    >Previous</a>
                </li>
                <li aria-current="page"
                    v-for="page in pagination.last_page"
                    :key="page"
                    :class="['page-item', {active: pagination.current_page === page}]"
                >
                    <a class="page-link"
                       @click="fetchPosts(page)"
                    >{{page}}</a>
                </li>
                <li class="page-item">
                    <a :class="['page-link', {disabled: pagination.current_page === pagination.last_page,}]"
                       @click="fetchPosts(nextPage)"
                    >Next</a>
                </li>
            </ul>
        </nav>
    </div>
</template>

<script>
import TheCard from "../components/TheCard";

import axios from "axios";

export default {
    components: {
        TheCard,
    },
    data() {
        return {
            posts: [],
            pagination: {},
        }
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
    },
    computed: {
        prevPage() {
            return this.pagination.current_page - 1
        },
        nextPage() {
            return this.pagination.current_page + 1
        }
    }
}
</script>

<style lang="scss" scoped>

</style>
