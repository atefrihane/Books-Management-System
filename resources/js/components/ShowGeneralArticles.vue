<template>
    <div>

        <div class="card">

            <div class="card-body">
             

                <table class="table table-bordered table-hover  table-responsive-sm">
                    <thead>
                        <tr>
                            <th scope="col">Photo</th>
                            <th scope="col">Title</th>
                            <th scope="col">Categories</th>
                            <th scope="col">Author</th>

                            <th scope="col">Status</th>
                            <th scope="col">Last modification</th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="article in allArticles">

                            <td class="style-image">
                                <div class="container">
                                    <img :src="article.photo ? article.photo : '/img/placeholder.jpg'" alt=""
                                        class="img-fluid"></div>

                            </td>
                            <td>{{article.title}}</td>
                            <td>{{article.categories.length}}</td>
                            <td>{{$root.ucfirst(article.author.first_name)+' '+$root.ucfirst(article.author.last_name)}}
                            </td>

                            <td>{{article.active == 1 ? 'Active' : 'Inactive'}}</td>
                            <td>{{article.updated_at}}</td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-secondary dropdown-toggle btn-hide" type="button"
                                        id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                        aria-expanded="false">

                                        <i class="fas fa-ellipsis-h"></i>
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        <a class="dropdown-item" :href="`/article/${article.id}`">Show details</a>
                                        <a class="dropdown-item" :href="`/article/${article.id}/update`">Edit</a>
                                        <a class="dropdown-item" href="#" data-toggle="modal"
                                            data-target="#exampleModal" @click="affectValue(article)">Delete</a>
                                    </div>
                                </div>
                            </td>

                        </tr>

                        <show-modal :element="this.article" v-on:removeItem="removeItem($event)" ref="modal"
                            v-if="this.article"></show-modal>

                    </tbody>
                </table>

            </div>
            <!-- /.card-body -->

        </div>

    </div>

</template>

<script>
    import ShowModal from './nested/ShowModal.vue'
    export default {
        mounted() {
            this.filterActiveArticles();

        },
        props: ['articles'],
        data() {
            return {
                allArticles: this.articles,
                isChecked: false,
                article: ''
            }

        },
        methods: {
           

            removeItem(event) {
                let articleStatus = event.active;

                axios
                    .post(`/api/article/${event.id}/delete`, {})
                    .then((response) => {
                        if (response.data.status == 200) {

                            this
                                .articles
                                .splice(this.articles.indexOf(event), 1);
                            this.allArticles = this.articles
                            toast.fire({
                                type: 'success',
                                title: 'Article deleted'
                            })

                            this.article = ''
                            this.$root.destroyDataTable()
                            this.$root.updateDataTable()
                        }

                        if (response.data.status == 404) {
                            swal2.fire({
                                type: 'error',
                                title: 'Article not found..',
                                allowOutsideClick: false,
                                showConfirmButton: true,
                                confirmButtonText: 'Fermer'
                            });
                        }
                    })

            },
            affectValue(article) {
                this.article = article
  
            }

        }

    }

</script>
