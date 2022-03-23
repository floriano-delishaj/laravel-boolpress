<template>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header d-flex">
                        Aggiunta di un nuovo post
                    </div>

                    <div class="card-body">

                        <div>

                            <div class="mb-3">
                                <label>Titolo</label>
                                <input type="text" name="title"
                                       class="form-control"
                                       v-model="formPost.title"
                                       placeholder="Inserisci il titolo" required>
                            </div>

                            <div class="mb-3">
                                <label>Contenuto</label>
                                <textarea name="content" rows="10"
                                          class="form-control"
                                          v-model="formPost.content"
                                          placeholder="Inizia a scrivere qualcosa..."
                                          required></textarea>
                            </div>

                            <div class="mb-3">
                                <label>Categoria</label>
                                <select name="category_id" class="form-select" v-model="formPost.category_id">
                                    <option value="">-- nessuna categoria --</option>

                                    <option v-for="category in categories" :key="category.id" :value="category.id">
                                        {{ category.name }}
                                    </option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label>Tags</label> <br/>
                                <div v-for="tag in tags" class="form-check form-check-inline">
                                    <input class="form-check-input"
                                           type="checkbox"
                                           :value="tag.id"
                                           :id="`tag_{{tag.id}}`"
                                           v-model="formPost.tags"
                                           name="tags[]"
                                    >
                                    <label :for="`tag_{{tag.id}}`" class="form-check-label">{{ tag.name }}</label>
                                </div>

                            </div>

                            <div class="form-group">
                                <a href="" class="btn btn-secondary">Annulla</a>
                                <button type="submit"
                                        class="btn btn-success"
                                        @click="formSubmit"
                                >Salva post</button>
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
            categories: [],
            tags: [],
            formPost:
                {
                    user_id: null,
                    title: '',
                    content: '',
                    slug: '',
                    category_id: '',
                    tags : [],  //errore
                },
            errorsFormValidations: null,
        }
    },
   methods: {
        async getData() {
            try {
                const res = await axios.get('/api/posts/create')
                this.categories = res.data.categories;
                this.tags = res.data.tags;
            } catch (error) {
                this.$router.replace({name: 'error', params: {message: error.message}})
            }
        },
       async formSubmit() {
            try {
                const res = await axios.post('/api/posts/store', this.formPost);
            } catch (error) {
                //422 errore di validazione
                if (error.response.status === 422) {
                    this.errorsFormValidations = error.response.data.errors;
                }
            }
       },
       getStoredUser() {
           const storedUser = localStorage.getItem('user')

           if(storedUser) {
               this.user = JSON.parse(storedUser);
               this.formPost.user_id = this.user.id
           } else {
               this.user = null;
               this.$router.replace( { name: 'home.index',})
           }
       }
    },
    mounted() {
        this.getData();

        this.getStoredUser();

        window.addEventListener('storedUserChanged', () => {
            this.getStoredUser();

        })
    }
}
</script>

<style lang="scss" scoped>

</style>
