<template>
    <div class="container mt-5">
        <div class="row row-cols-1 row-cols-md-2 g-4">
            <TheCard v-for="post in posts" :key="post.id" :post="post"/>
        </div>
        <nav aria-label="pagination card" class="my-5">
            <ul class="pagination">
                <li class="page-item">
                    <a class="page-link"
                       @click="$emit('fetchPosts', prevPage)"
                    >Previous</a>
                </li>
                <li aria-current="page"
                    v-for="page in pagination.last_page"
                    :key="page"
                    :class="['page-item']"
                >
                    <a class="page-link"
                       @click="$emit('fetchPosts', page)"
                    >{{page}}</a>
                </li>
                <li class="page-item">
                    <a class="page-link"
                       @click="$emit('fetchPosts', nextPage)"
                    >Next</a>
                </li>
            </ul>
        </nav>
    </div>
</template>

<script>
import TheCard from "./TheCard";

export default {
    components: {
        TheCard,
    },
    props: {
        pagination: Object,
        posts: Array,
    },
    data () {
        return {
           // prevPage: this.pagination.current_page - 1,
           // nextPage: this.pagination.current_page + 1,
            // non si può fare perché c'è l'asyc e await di mezzo
        }
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
