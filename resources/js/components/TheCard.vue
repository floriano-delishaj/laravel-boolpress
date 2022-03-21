<template>
    <div>
        <div class="col">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">{{post.title}}</h4>
                </div>
                <div class="card-body">
                    <p class="card-text">{{post.content}}</p>
                </div>
                <div class="card-footer">
                    <p>Autore: <strong>{{post.user.name}}</strong></p>
                    <div v-if="post.category">
                        Categorie:
                        <strong class="badge bg-success text-white mx-1 mb-3">{{post.category.name}}</strong>
                    </div>
                    <div v-if="post.tags.length > 0">
                        Tags:
                        <span v-for="tags in post.tags">
                            <span class="badge bg-danger text-white mx-1 mb-3">{{tags.name}}</span>
                        </span>
                    </div>
                    <hr>
                    <div class="my-3 text-end">
                        <router-link :to="{ name: 'posts.show', params: { post: post.slug } }">Dettagli</router-link>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        post: Object,
    }
}
</script>

<style lang="scss" scoped>

</style>
