<template>
    <div class="container mt-4 mb-4">
        <div class="form-group mt-2">
            <div class="d-flex flex-row bd-highlight">
                <div class="p-2 bd-highlight">
                    <h3 class="font-weight-normal">Article(s)</h3>
                </div>

            </div>
        </div>
        <table class="table table-bordered table-hover  table-responsive-md mb-3 ">
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
                <tr v-for="article in this.formattedArticles">

                    <td style="width:5%;">

                     <img :src="article.photo ? article.photo : '/img/placeholder.jpg'" alt="" class="img-fluid"></td>
                        <td>{{article.title}}</td>
                        <td>{{article.title}}</td>
                        <td>{{article.title}}</td>
                        <td>{{article.created_at}}</td>
                        <td>{{article.active == 0 ? 'Active'  : 'Inactive'}}</td>
                        <td>{{article.active == 0 ? 'Active'  : 'Inactive'}}</td>
                        <td>
                            <div class="form-check mt-1">
                                <input
                                    class="form-check-input"
                                    type="checkbox"
                                    @click="matchArticle(article.id)"
                                    :checked="article.selected"></div>
                            </td>
                            <show-modal :element="article" v-on:requiredValue="updatearticles($event)"></show-modal>
                        </tr>

                    </tbody>
                </table>

            </div>

        </template>

        <script>
            export default {
                mounted() {

                    this
                        .articles
                        .forEach(article => {

                            this
                                .formattedArticles
                                .push({
                                    id: article.id,
                                    photo: article.photo,
                                    title: article.title,
                                    categories: [],
                                    authors: [],
                                    published_year: article.published_year,
                                    active: article.active,
                                    created_at: article.created_at,
                                    selected: false

                                })
                        })
                    if (this.oldSelectedArticles && this.oldSelectedArticles.length > 0) {
                        this.selectedArticles = this.oldSelectedArticles
                        this
                            .formattedArticles
                            .forEach(formattedArticle => {
                                this
                                    .oldSelectedArticles
                                    .forEach(selectedArticle => {

                                        if (formattedArticle.id == selectedArticle) {

                                            formattedArticle.selected = true;
                                        }

                                    })
                            })

                    }

                },
                props : [
                    'articles', 'oldSelectedArticles'
                ],
                data() {
                    return {formattedArticles: [], selectedArticles: []}

                },
                methods : {
                    matchArticle(id) {

                        let isSelected = false;
                        this
                            .formattedArticles
                            .forEach(article => {
                                if (article.id == id) {
                                    article.selected = !article.selected
                                    isSelected = !article.selected

                                }

                            })

                        if (!isSelected) {
                            toast.fire({type: 'success', title: 'Article selectionné'})
                            this
                                .selectedArticles
                                .push(id)
                            this.$emit('submitArticles', this.selectedArticles)

                        } else {
                            toast.fire({type: 'success', title: 'Article retiré'})

                            this.selectedArticles = this
                                .selectedArticles
                                .filter(selectedId => {
                                    return selectedId != id;
                                })

                            this.$emit('submitArticles', this.selectedArticles)
                        }

                    }

                }

            }
        </script>