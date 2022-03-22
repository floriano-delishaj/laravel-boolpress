<template>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header d-flex">
                        Aggiunta di un nuovo post
                    </div>

                    <div class="card-body">

                        <form action="" method="post">

                            <div class="mb-3">
                                <label>Titolo</label>
                                <input type="text" name="title"
                                       class="form-control"
                                       placeholder="Inserisci il titolo" required>
                            </div>

                            <div class="mb-3">
                                <label>Contenuto</label>
                                <textarea name="content" rows="10"
                                          class="form-control"
                                          placeholder="Inizia a scrivere qualcosa..."
                                          required></textarea>
                            </div>

                            <div class="mb-3">
                                <label>Categoria</label>
                                <select name="category_id" class="form-select">
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
                                           :id="tag.id"
                                           name="tags[]"
                                    >
                                    <label class="form-check-label">{{ tag.name }}</label>
                                </div>

                            </div>

                            <div class="form-group">
                                <a href="" class="btn btn-secondary">Annulla</a>
                                <button type="submit" class="btn btn-success">Salva post</button>
                            </div>
                        </form>
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
        }
    },
   methods: {
        async getData() {
            try {
                const res = await axios.get('/api/posts/create')
                this.categories = res.data.categories;
                this.tags = res.data.tags;
                console.log(this.categories)
                console.log(this.tags)
            } catch (error) {
                this.$router.replace({name: 'error', params: {message: error.message}})
            }
        }
    },
    mounted() {
        this.getData();
    }
}
</script>

<style lang="scss" scoped>

</style>
