<template>
    <div class="container mt-5">
        <div v-if="!formSubmitted" class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header d-flex">
                        Aggiunta di un nuovo post
                    </div>

                    <div class="card-body">
                        <ValidationObserver v-slot="{ handleSubmit }">
                                <div>
                                    <div class="mb-3">
                                        <label>Titolo</label>
                                        <ValidationProvider rules="required|alpha_spaces|min:5|max:120" v-slot="{ errors }">
                                            <input type="text" name="title"
                                                   class="form-control"
                                                   v-model="formPost.title"
                                                   placeholder="Inserisci il titolo" required
                                            >
                                            <span class="invalid-feedback"
                                                    v-if="errors">
                                                <span v-for="error in errors">{{error}}</span>
                                            </span>

                                            <span class="invalid-feedback"
                                                  v-if="errorsFormValidations && errorsFormValidations.title"
                                            >
                                                <span v-for="errors in errorsFormValidations.title">{{errors}}</span>
                                            </span>
                                        </ValidationProvider>

                                    </div>

                                    <div class="mb-3">
                                        <label>Carica file</label>
                                            <input type="file"
                                                   name="path_img"
                                                   class="form-control"
                                                   @change="onAttachmentChange"
                                                   placeholder="Allega file"
                                            >
                                            <span class="invalid-feedback"
                                                  v-if="errorsFormValidations && errorsFormValidations.path_img"
                                            >
                                                <span v-for="errors in errorsFormValidations.path_img">{{errors}}</span>
                                            </span>
                                    </div>

                                    <div class="mb-3">
                                        <label>Contenuto</label>
                                        <ValidationProvider rules="required|min:10|max:300" v-slot="{ errors }">
                                            <textarea name="content" rows="10"
                                                      class="form-control"
                                                      v-model="formPost.content"
                                                      placeholder="Inizia a scrivere qualcosa..."
                                                      required>
                                            </textarea>

                                            <span class="invalid-feedback"
                                                  v-if="errors">
                                                <span v-for="error in errors">{{error}}</span>
                                            </span>

                                            <span class="invalid-feedback"
                                                  v-if="errorsFormValidations && errorsFormValidations.content"
                                            >
                                                <span v-for="errors in errorsFormValidations.content">{{errors}}</span>
                                            </span>
                                        </ValidationProvider>
                                    </div>

                                    <div class="mb-3">
                                        <label>Categoria</label>
                                        <select name="category_id" class="form-select" v-model="formPost.category_id">
                                            <option value="">-- nessuna categoria --</option>

                                            <option v-for="category in categories" :key="category.id" :value="category.id">
                                                {{ category.name }}
                                            </option>
                                        </select>

                                        <span class="invalid-feedback"
                                              v-if="errorsFormValidations && errorsFormValidations.category_id"
                                        >
                                            <span v-for="errors in errorsFormValidations.category_id">{{errors}}</span>
                                        </span>

                                    </div>

                                    <div class="mb-3">
                                        <label>Tags</label> <br/>
                                        <div v-for="tag in tags" class="form-check form-check-inline">
                                            <input class="form-check-input"
                                                   type="checkbox"
                                                   :value="tag.id"
                                                   :id="`tag_${tag.id}`"
                                                   v-model="formPost.tags"
                                                   name="tags[]"
                                            >
                                            <label :for="`tag_${tag.id}`" class="form-check-label">{{ tag.name }}</label>

                                            <span class="invalid-feedback"
                                                  v-if="errorsFormValidations && errorsFormValidations.tags"
                                            >
                                            <span v-for="errors in errorsFormValidations.tags">{{errors}}</span>
                                        </span>

                                        </div>

                                    </div>

                                    <div class="form-group">
                                        <router-link to="/" class="btn btn-secondary">Annulla</router-link>
                                        <button type="submit"
                                                class="btn btn-success"
                                                @click="formSubmit"
                                        >Salva post</button>
                                    </div>
                                </div>
                        </ValidationObserver>
                    </div>
                </div>
            </div>
        </div>

        <div v-else class="alert alert-success py-5">
            <h4>Un nuovo post è stato creato.</h4>
            <p class="lead">
                Il <strong>post</strong> è stato creato con successo, sarei reindirizzato a breve.
            </p>
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
                    path_img: null,
                    slug: '',
                    category_id: '',
                    tags : [],
                },
            formSubmitted: false,
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
                this.errorsFormValidations = null;

                const formDataInstance = new FormData();
                formDataInstance.append("user_id", this.formPost.user_id)
                formDataInstance.append("title", this.formPost.title)
                formDataInstance.append("content", this.formPost.content)
                formDataInstance.append("slug", this.formPost.slug)
                formDataInstance.append("category_id", this.formPost.category_id)

                    formDataInstance.append("path_img", this.formPost.img_path)

                for (let i = 0; i < this.formPost.tags.length; i++)
                {
                    formDataInstance.append("tags[]", this.formPost.tags[i])
                }

                const res = await axios.post('/api/posts/store', formDataInstance);
                this.formSubmitted = true;

                setTimeout(() => {
                    this.$router.replace({name: 'home.index'});
                }, 1000);
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
       },
       onAttachmentChange(event) {
            console.log(event)
           this.formPost.img_path = event.target.files[0];
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
