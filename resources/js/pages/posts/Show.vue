<template>
    <div>
        <div class="container mt-5">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header d-flex">
                            <h1>Dettagli post: {{post.title}}</h1>
                        </div>

                        <div class="card-body">
                            {{ post.content }}
                        </div>
                        <div class="card-footer d-flex justify-content-between">
                            <div>
                                <ul class="list-group">
                                    <li class="list-group-item">
                                        <p>Creato il <i>{{post.created_at}}</i></p>
                                        <p>Modificato <i>{{post.updated_at}}</i></p>
                                    </li>
                                  <li class="list-group-item" v-if="post.category && post.category !== null">
                                        Categoria: <span class="badge bg-danger text-white mx-1 mb-3">{{post.category.name}}</span>
                                    </li>
                                 <li class="list-group-item" v-if="post.tags && post.tags.length > 0">
                                        Tags:
                                        <span class="badge bg-success text-white mx-1 mb-3"
                                              v-for="tag in post.tags"
                                              :key="tag.id"
                                        >
                                            {{tag.name}}
                                        </span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';

export default {

    data() {
        return {
            post: {}
        }
    },
    methods: {
        async fetchPost() {
            try {
                const res = await axios.get('/api/posts/' + this.$route.params.post)
                this.post = res.data;

            } catch (error) {
                this.$router.replace( { name: 'error', params: { message: error.message } })
            }

        }
    },
    mounted() {
        this.fetchPost();
    }
}
</script>
