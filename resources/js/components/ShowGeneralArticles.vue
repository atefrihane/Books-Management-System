<template>
    <div>

        <div class="card">

            <div class="card-body">
                <div class="form-check">
                    <input
                        class="form-check-input filterarticles"
                        type="checkbox"
                        value=""
                        id="defaultCheck1"
                        @click="filterArticlesClick()">
                        <label class="form-check-label" for="defaultCheck1">
                            Afficher les élements desactivés
                        </label>
                    </div>

                    <table class="table table-bordered table-hover  table-responsive-sm">
                        <thead>
                            <tr>
                                <th scope="col">Photo</th>
                                <th scope="col">Titre</th>
                                <th scope="col">Domaine(s)</th>
                                <th scope="col">Auteur(s)</th>
                                <th scope="col">Année</th>
                                <th scope="col">Etat</th>
                                <th scope="col">Dérniere modification</th>
                                <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="article in allArticles">

                                <td class="style-image">
                                    <div class="container">
                                        <img :src="article.photo ? article.photo : '/img/placeholder.jpg'" alt="" class="img-fluid"></div>

                                    </td>
                                    <td>{{article.title}}</td>
                                    <td>{{article.categories.length}}</td>
                                    <td>{{article.authors.length}}</td>
                                    <td>{{article.published_year}}</td>
                                    <td>{{article.active == 1 ? 'Actif' : 'Inactif'}}</td>
                                    <td>{{article.updated_at}}</td>
                                    <td>
                                        <div class="dropdown">
                                            <button
                                                class="btn btn-secondary dropdown-toggle btn-hide"
                                                type="button"
                                                id="dropdownMenuButton"
                                                data-toggle="dropdown"
                                                aria-haspopup="true"
                                                aria-expanded="false">

                                                <i class="fas fa-ellipsis-h"></i>
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                <a class="dropdown-item" :href="`/article/${article.id}`">Voir détails</a>
                                                <a class="dropdown-item" :href="`/article/${article.id}/update`">Modifier</a>
                                                <a
                                                    class="dropdown-item"
                                                    href="#"
                                                    data-toggle="modal"
                                                    data-target="#exampleModal"
                                                    @click="affectValue(article)">Supprimer</a>
                                            </div>
                                        </div>
                                    </td>

                                </tr>

                                <show-modal
                                    :element="this.article"
                                    v-on:removeItem="removeItem($event)"
                                    ref="modal"
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
                props : ['articles'],
                data() {
                    return {allArticles: this.articles, isChecked: false, article: ''}

                },
                methods : {
                    filterActiveArticles() {

                        this.allArticles = _.filter(this.allArticles, function (o) {
                            return o.active;
                        });
                    },
                    filterArticlesClick() {
                        this
                            .$root
                            .destroyDataTable()
                        this.isChecked = !this.isChecked;

                        // show all articles
                        if (this.isChecked) {

                            this.allArticles = this.articles
                            this
                                .$root
                                .updateDataTable()

                            return;

                        }
                        //show only active

                        this.filterActiveArticles()
                        this
                            .$root
                            .updateDataTable()
                        return;

                    },

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
                                    toast.fire({type: 'success', title: 'Article supprimée'})

                                    this.isChecked = !this.isChecked

                                    this.filterArticlesClick()
                                }

                                if (response.data.status == 404) {
                                    swal2.fire({type: 'error', title: 'Revue introuvable..', allowOutsideClick: false, showConfirmButton: true, confirmButtonText: 'Fermer'});
                                }
                            })

                    },
                    affectValue(article) {
                        this.article = article
                        let element = this.$refs.modal
                        $(element).modal('show')
                    }

                }

            }
        </script>