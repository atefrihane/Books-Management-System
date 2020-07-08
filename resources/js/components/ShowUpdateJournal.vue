<template>
    <div class="container-fluid">
        <div class="card card-primary">
            <h3 class=" p-4">Modifier une revue</h3>

            <form role="form">
                <div class="card-body">
                    <show-errors :errors="errors"> </show-errors>
                    <div class="row">
                        <div class="col-md-12">
                            <img :src="journal.photo ? journal.photo : '/img/placeholder.jpg'"
                                class="rounded mx-auto d-block mb-3 img-upload" style="height:20vh;"
                                @click="$refs.file.click()">
                            <input type="file" ref="file" style="display: none" @change="uploadFile($event,0)">

                        </div>

                    </div>

                
                    <div class="row">
                        <div class="col-md-12">
                            <label for="exampleInputEmail1">Titre</label>
                            <input type="text" class="form-control" placeholder="Titre.." v-model="journal.title">
                        </div>

                    </div>


                    <div class="row mt-3">

                        <div class="col-md-12">
                            <label for="exampleInputEmail1" style="display: block;">Langues</label>
                            <div class="form-group">

                                <select class="form-control" @change="selectLanguage($event)">
                                    <option :selected="journal.languages.length == 0"
                                        :disabled="journal.languages.length > 0">Selectionner une langue
                                    </option>
                                    <option :value="language.id" v-for="language in languages"
                                        :disabled="language.disabled">
                                        {{$root.ucfirst(language.name)}}</option>

                                </select>
                            </div>
                            <div class="btn-group mb-3 m-1" v-if="journal.languages.length >  0"
                                v-for="journalLanguage in journal.languages">
                                <button type="button" class="btn btn-outline-secondary">
                                    {{$root.ucfirst(journalLanguage.name)}}</button>
                                <button type="button" class="btn btn-outline-secondary"
                                    @click="resetLanguage(journalLanguage)">
                                    <span aria-hidden="true">×</span></button>
                            </div>



                        </div>
                    </div>


                    <div class="row">
                        <div class="col-md-12">
                            <label class="mt-2 mb-2">Directeur</label>
                            <input type="text" class="form-control" placeholder="Directeur.."
                                v-model="journal.director">
                        </div>
                     

                    </div>

                    <div class="row mt-3">
                        <div class="col-md-6">
                            <label for="exampleInputEmail1" class="mt-2 mb-2">Année de publication</label>
                            <input type="number" class="form-control" placeholder="Année de publication.."
                                v-model="journal.published_year">
                        </div>
                        <div class="col-md-6">
                            <label for="exampleInputEmail1" class="mt-2">Editeur</label>
                            <input type="text" class="form-control" placeholder="Editeur.." v-model="journal.editor">

                        </div>

                    </div>






                    <div class="row mt-3">
                        <div class="col-md-12">
                            <label for="exampleInputEmail1">Déscription</label>
                            <textarea class="form-control" rows="3" placeholder="Déscription.."
                                v-model="journal.description"></textarea>
                        </div>

                    </div>






                    <show-authors v-if="this.searchedAuthors.length > 0" :authors="this.authors"
                        :selectedAuthors="this.selectedAuthors" :oldSearchedAuthors="this.searchedAuthors"
                        v-on:matchAuthors="matchAuthors($event)">
                    </show-authors>
                    <div class="mx-auto mt-4" style="width: 200px;">
                        <div class="row">
                            <button type="button" class="btn btn-danger ml-3" @click="cancelJournal()">Annuler</button>
                            <button type="button" class="btn btn-primary ml-4" @click="submitUpdatejournal()"
                                :disabled="disabled">Confirmer</button>
                        </div>
                    </div>

                </div>
            </form>




        </div>


    </div>
</template>

<script>
    import ShowArticles from './nested/ShowArticles.vue'
    import ShowAuthors from './nested/ShowAuthors.vue'
    import ShowErrors from './nested/ShowErrors.vue'
    export default {
        mounted() {
            this.updatejournal()
            this.formatAuthors()
            this.formatLanguages()



        },
        props: ['languages', 'authors', 'journal_details'],
        data() {
            return {
                digital_name: 'Importer un fichier',
                availablePaper: false,
                availableDigital: false,
                disabled: false,
                freeDigital: false,
                selected_articles: [],
                selectedAuthors: [],
                searchedAuthors: [],
                errors: [],
                journal: {
                    id: '',
                    active: 1,
                    title: '',
                    languages: [],
                    authors: [],
                    published_year: '',
                    director: '',
                    editor: '',
                    description: '',
                    photo: '/img/placeholder.jpg',



                }

            }
        },
        methods: {
            updatejournal() {
                this.journal = this.journal_details
                this.journal.paper_price ? this.availablePaper = true : this.availablePaper = false
                this.journal.digital_link ? this.availableDigital = true : this.availableDigital = false
                this.journal.digital_price ? this.freeDigital = false : ''
                if (this.journal.digital_link && !this.journal.digital_price) {
                    this.freeDigital = true;
                }
                this.selected_articles = _.map(this.journal_details.articles, 'id');
                this.journal.articles = this.selected_articles
                this.selectedAuthors = _.map(this.journal_details.authors, 'id');


            },
            formatAuthors() {
                if (this.journal.authors && this.journal.authors.length > 0) {
                    let oldAuthors = []
                    this.journal.authors.forEach(oldAuthor => {
                        this.searchedAuthors.push({
                            id: oldAuthor.id,
                            fullName: oldAuthor.first_name + ' ' + oldAuthor.last_name,
                            biography: oldAuthor.biography,
                            photo: oldAuthor.photo,
                            selected: true,

                        })

                        oldAuthors.push(oldAuthor.id)

                    })
                    this.journal.authors = oldAuthors

                }
            },

            formatLanguages() {
                for (let i = 0; i < this.languages.length; i++) {
                    this.$set(this.languages[i], 'disabled', false)

                }

                this.journal.languages.forEach(journalLanguage => {
                    this.languages.forEach(language => {
                        if (journalLanguage.id == language.id) {
                            language.disabled = true;
                        }

                    })

                })

            },
            async uploadFile(event, type) {
                // 0 image
                // 1 pdf

                let file = await this.$root.uploadFile(event, type);
                if (file) {
                    if (type == 0) {
                        this.journal.photo = file.link

                        return;
                    } else {
                        this.journal.digital_link = file.link
                        this.digital_name = file.name
                        return;
                    }


                }




                swal2.fire({
                    icon: 'error',
                    title: 'File not supported',
                    allowOutsideClick: false,
                    showConfirmButton: true,
                    confirmButtonText: 'Fermer'


                });
                return;









            },

            selectLanguage(event) {
                let id = event.target.value;
                if (id) {
                    let checkValue = _.find(this.languages, function (o) {
                        return o.id == id;
                    });
                    this.journal.languages.push(checkValue)


                    this.languages.forEach(language => {
                        language.id == id ? language.disabled = true : ''
                    })


                }


            },

            resetLanguage(journalLanguage) {
                this.journal.languages.splice(this.journal.languages.indexOf(journalLanguage), 1);

                this.languages.forEach(language => {
                    language.id == journalLanguage.id ? language.disabled = false : ''
                })
            },
            matchAuthors(authors) {
                this.journal.authors = authors

            },


            validateData() {
                this.errors = []
                if (this.journal.photo == '/img/placeholder.jpg') {
                    this.disabled = false;
                    this.errors.push('Veuillez importer une photo pour le livre');
                    window.scrollTo(0, 0);
                    return;
                }
                if (!this.journal.title) {
                    this.disabled = false;
                    this.errors.push('Le titre est requis');
                    window.scrollTo(0, 0);
                    return;
                }


                if (this.journal.languages.length == 0) {
                    this.disabled = false;
                    this.errors.push('Veuillez séléctionner au moins une langue');
                    window.scrollTo(0, 0);
                    return;
                }

                if (this.journal.authors.length == 0) {
                    this.disabled = false;
                    this.errors.push('Veuillez séléctionner au moins un auteur');
                    window.scrollTo(0, 0);
                    return;
                }




                 if (!this.journal.director) {
                    this.disabled = false;
                    this.errors.push('Le directeur est requis');
                    window.scrollTo(0, 0);
                    return;
                }

                if (!this.journal.published_year) {
                    this.disabled = false;
                    this.errors.push('L\'année de publication est requise');
                    window.scrollTo(0, 0);
                    return;
                }

                if (!this.journal.editor) {
                    this.disabled = false;
                    this.errors.push('L\'editeur est requis');
                    window.scrollTo(0, 0);
                    return;
                }



                if (!this.journal.description) {
                    this.errors.push('La description est requise');
                    window.scrollTo(0, 0);
                    return;
                }





                return true;



            },
            submitUpdatejournal() {
                this.disabled = true;
                let validate = this.validateData()
                if (validate) {

                    this.$Progress.start()
                    axios.post(`/api/journal/${this.journal.id}/update`, {
                            journal: this.journal
                        })
                        .then((response) => {
                            this.$Progress.finish()
                            if (response.data.status == 200) {
                                swal2.fire({
                                    icon: 'success',
                                    title: 'Revue modifiée avec succés',
                                    allowOutsideClick: false,
                                    showConfirmButton: true,
                                    confirmButtonText: 'Fermer'


                                }).then((result) => {
                                    if (result.value) {
                                        window.location = '/journals';
                                    }
                                })
                            }
                        })
                        .catch((error) => {
                            this.$Progress.fail()
                            this.disabled = false;
                            if (error.response.status == 422) {
                                this.errors = []
                                let errors = Object.values(error.response.data.errors);
                                errors = _.flatMap(errors);
                                this.errors = errors;


                                window.scrollTo(0, 0);
                            }
                        });


                }




            },
            cancelJournal() {
                window.location = '/journals'
            }


        }

    }

</script>
