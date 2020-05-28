<template>
    <div class="container-fluid">
        <div class="card card-primary">
            <h3 class=" p-4">Modifier un ouvrage</h3>

            <form role="form">
                <div class="card-body">
                    <show-errors :errors="errors"> </show-errors>
                    <div class="row">
                        <div class="col-md-12">
                            <img :src="book.photo ? book.photo : '/img/placeholder.jpg'" class="rounded mx-auto d-block mb-3 img-upload" style="height:20vh;"
                                @click="$refs.file.click()">
                            <input type="file" ref="file" style="display: none" @change="uploadFile($event,0)">

                        </div>

                    </div>

                    <div class="form-group">
                        <label>Etat</label>
                        <select class="form-control" v-model="book.active">
                            <option :value="1">Actf</option>
                            <option :value="0">Inactif</option>
                        </select>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <label for="exampleInputEmail1">Titre</label>
                            <input type="text" class="form-control" placeholder="Titre.." v-model="book.title">
                        </div>

                    </div>


                    <div class="row mt-3">
                        <div class="col-md-6">
                            <label for="exampleInputEmail1" style="display: block;">Catégories</label>
                            <div class="form-group">

                                <select class="form-control" @change="selectCategory($event)">
                                    <option :disabled="book.categories.length > 0"
                                        :selected="book.categories.length == 0">Selectionner une catégorie
                                    </option>
                                    <option :value="category.id" v-for="category in categories"
                                        :disabled="category.disabled">
                                      {{$root.ucfirst(category.name)}}</option>
                                </select>
                            </div>
                            <div class="btn-group mb-3 mt-1 ml-2" v-for="bookCategory in book.categories">
                                <button type="button" class="btn btn-outline-primary"> {{$root.ucfirst(bookCategory.name)}}</button>
                                <button type="button" class="btn btn-outline-primary"
                                    @click="resetCategory(bookCategory)">
                                    <span aria-hidden="true">×</span></button>
                            </div>



                        </div>
                        <div class="col-md-6">
                            <label for="exampleInputEmail1" style="display: block;">Langues</label>
                            <div class="form-group">

                                <select class="form-control" @change="selectLanguage($event)">
                                    <option :selected="book.languages.length == 0"
                                        :disabled="book.languages.length > 0">Selectionner une langue
                                    </option>
                                    <option :value="language.id" v-for="language in languages"
                                        :disabled="language.disabled">
                                       {{$root.ucfirst(language.name)}}</option>

                                </select>
                            </div>
                            <div class="btn-group mb-3 m-1" v-if="book.languages.length >  0"
                                v-for="bookLanguage in book.languages">
                                <button type="button" class="btn btn-outline-secondary"> {{$root.ucfirst(bookLanguage.name)}}</button>
                                <button type="button" class="btn btn-outline-secondary"
                                    @click="resetLanguage(bookLanguage)">
                                    <span aria-hidden="true">×</span></button>
                            </div>



                        </div>
                    </div>




                    <div class="row">
                        <div class="col-md-6">
                            <label for="exampleInputEmail1" class="mt-2 mb-2">Année de publication</label>
                            <input type="number" class="form-control" placeholder="Année de publication.."
                                v-model="book.published_year">
                        </div>
                        <div class="col-md-6">
                            <label for="exampleInputEmail1" class="mt-2">Editeur</label>
                            <input type="text" class="form-control" placeholder="Editeur.." v-model="book.editor">

                        </div>

                    </div>




                    <div class="row mt-3">
                        <div class="col-md-6">
                            <label for="exampleInputEmail1">Nombre de pages</label>
                            <input type="number" class="form-control" placeholder="Nombre de pages.."
                                v-model="book.count_pages">
                        </div>
                        <div class="col-md-6">
                            <label for="exampleInputEmail1">ISBN</label>
                            <input type="text" class="form-control" placeholder="ISBN.." v-model="book.isbn">

                        </div>

                    </div>



                    <div class="row mt-3">
                        <div class="col-md-12">
                            <label for="exampleInputEmail1">Déscription</label>
                            <textarea class="form-control" rows="3" placeholder="Déscription.."
                                v-model="book.description"></textarea>
                        </div>

                    </div>
                    <div class="container mt-4">
                        <div class="form-group mt-2 mb-2">
                            <div class="d-flex flex-row bd-highlight">
                                <div class="p-2 bd-highlight">
                                    <h3 class="font-weight-normal">Vérsion Numérique</h3>
                                </div>


                                <div class="p-2 ml-2 bd-highlight">
                                    <div class="form-check mt-1">
                                        <input class="form-check-input" type="checkbox" :checked="availableDigital"
                                            @click="setAvailableDigital()">
                                        <label class="form-check-label" for="exampleCheck1">Disponible</label>


                                    </div>
                                </div>


                            </div>
                        </div>
                        <div class="rounded-top" style="border: 1px solid #ced4da;">

                            <div class="row" v-if="book.digital_link">
                                <iframe :src="book.digital_link" class="mx-auto m-3" style="width:600px; height:500px;"
                                    frameborder="0">
                                </iframe>
                            </div>
                            <div class="p-4">
                                <div class="input-group mt-2">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="inputGroupFile02"
                                            @change="uploadFile($event,1)" :disabled="!availableDigital">
                                        <label class="custom-file-label" for="inputGroupFile02">{{digital_name}}</label>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-md-6 mb-2"> <input type="number" class="form-control"
                                            placeholder="Prix.." v-model="book.digital_price"
                                            :disabled="freeDigital || !availableDigital"></div>
                                    <div class="col-md-6">
                                        <div class="form-check mt-1">
                                            <input class="form-check-input" type="checkbox"
                                                :disabled="!availableDigital" @click="setFreeDigital()" :checked="freeDigital">
                                            <h5>Gratuit à télécharger</h5>
                                        </div>
                                    </div>

                                </div>


                            </div>
                        </div>

                    </div>
                    <div class="container mt-4">
                        <div class="form-group mt-2 mb-2">
                            <div class="d-flex flex-row bd-highlight">
                                <div class="p-2 bd-highlight">
                                    <h3 class="font-weight-normal">Vérsion P/apier</h3>
                                </div>
                                <div class="p-2 ml-5 bd-highlight">
                                    <div class="form-check mt-1">
                                        <input class="form-check-input" type="checkbox" :checked="availablePaper"
                                            @click="setAvailablePaper()">
                                        <label class="form-check-label" for="exampleCheck1">Disponible</label>
                                    </div>
                                </div>


                            </div>
                        </div>
                        <div class="rounded-top" style="border: 1px solid #ced4da;">
                            <div class="p-4">
                                <div class="row">
                                    <div class="col-md-3 mb-3">
                                    <label for="">Hauteur</label>
                                    <input type="number" class="form-control"
                                            placeholder="Hauteur" v-model="book.height" :disabled="!availablePaper">
                                    </div>
                                    <div class="col-md-3 mb-3">
                                      <label for="">Largeur</label>
                                    <input type="number" class="form-control"
                                            placeholder="Largeur" v-model="book.width" :disabled="!availablePaper">
                                    </div>
                                    <div class="col-md-3  mb-3">
                                      <label for="">Epaisseur</label>
                                    <input type="number" class="form-control"
                                            placeholder="Epaisseur" v-model="book.thickness"
                                            :disabled="!availablePaper"></div>
                                    <div class="col-md-3  mb-3">
                                      <label for="">Poids</label>
                                    <input type="number" class="form-control"
                                            placeholder="Poids" v-model="book.weight" :disabled="!availablePaper">
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-md-12 mb-2"> 
                                      <label for="">Prix</label>
                                    <input type="number" class="form-control"
                                            placeholder="Prix.." v-model="book.paper_price" :disabled="!availablePaper">
                                    </div>

                                </div>


                            </div>
                        </div>

                    </div>


                    <show-articles v-if="this.selected_articles.length >0" :articles="this.articles"
                        :oldSelectedArticles="this.selected_articles" @submitArticles="affectArticles($event)">
                    </show-articles>

                    <show-authors v-if="this.searchedAuthors.length > 0" :authors="this.authors"
                        :selectedAuthors="this.selectedAuthors" :oldSearchedAuthors="this.searchedAuthors"
                        v-on:matchAuthors="matchAuthors($event)">
                    </show-authors>
                    <div class="mx-auto mt-4" style="width: 200px;">
                        <div class="row">
                            <button type="button" class="btn btn-danger ml-3" @click="cancelBook()">Annuler</button>
                            <button type="button" class="btn btn-primary ml-4" @click="submitUpdateBook()"
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
            this.updateBook()
            this.formatAuthors()
            this.formatCategories()
            this.formatLanguages()



        },
        props: ['languages', 'categories', 'articles', 'authors', 'book_details'],
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
                book: {
                    id: '',
                    active: 1,
                    title: '',
                    categories: [],
                    languages: [],
                    articles: [],
                    authors: [],
                    published_year: '',
                    editor: '',
                    count_pages: '',
                    isbn: '',
                    description: '',
                    height: '',
                    width: '',
                    thickness: '',
                    weight: '',
                    paper_price: '',
                    digital_price: '',
                    photo: '/img/placeholder.jpg',
                    digital_link: '',


                }

            }
        },
        methods: {
            updateBook() {
                this.book = this.book_details
                this.book.paper_price ? this.availablePaper = true : this.availablePaper = false
                this.book.digital_link ? this.availableDigital=true : this.availableDigital = false
                this.book.digital_price ? this.freeDigital=false : ''
                   if(this.book.digital_link && !this.book.digital_price)
                {
                    this.freeDigital=true;
                }
                this.selected_articles = _.map(this.book_details.articles, 'id');
                this.book.articles=this.selected_articles
                this.selectedAuthors = _.map(this.book_details.authors, 'id');
               

            },
            formatAuthors() {
                if (this.book.authors && this.book.authors.length > 0) {
                    let oldAuthors = []
                    this.book.authors.forEach(oldAuthor => {
                        this.searchedAuthors.push({
                            id: oldAuthor.id,
                            fullName: oldAuthor.first_name + ' ' + oldAuthor.last_name,
                            biography: oldAuthor.biography,
                            photo: oldAuthor.photo,
                            selected: true,

                        })

                       oldAuthors.push(oldAuthor.id)

                    })
                    this.book.authors=oldAuthors

                }
            },
            formatCategories() {
                for (let i = 0; i < this.categories.length; i++) {
                    this.$set(this.categories[i], 'disabled', false)

                }
                this.book.categories.forEach(bookCategory => {
                    this.categories.forEach(category => {
                        if (bookCategory.id == category.id) {
                            category.disabled = true;
                        }

                    })

                })

            },
            formatLanguages() {
                for (let i = 0; i < this.languages.length; i++) {
                    this.$set(this.languages[i], 'disabled', false)

                }

                this.book.languages.forEach(bookLanguage => {
                    this.languages.forEach(language => {
                        if (bookLanguage.id == language.id) {
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
                        this.book.photo = file.link

                        return;
                    } else {
                        this.book.digital_link = file.link
                        this.digital_name = file.name
                        return;
                    }


                }




                swal2.fire({
                    type: 'error',
                    title: 'Format fichier non supporté',
                    allowOutsideClick: false,
                    showConfirmButton: true,
                    confirmButtonText: 'Fermer'


                });
                return;









            },
            selectCategory(event) {
                let id = event.target.value;
                if (id) {
                    let checkValue = _.find(this.categories, function (o) {
                        return o.id == id;
                    });
                    this.book.categories.push(checkValue)


                    this.categories.forEach(category => {
                        category.id == id ? category.disabled = true : ''
                    })



                }




            },
            selectLanguage(event) {
                let id = event.target.value;
                if (id) {
                    let checkValue = _.find(this.languages, function (o) {
                        return o.id == id;
                    });
                    this.book.languages.push(checkValue)


                    this.languages.forEach(language => {
                        language.id == id ? language.disabled = true : ''
                    })


                }


            },
            resetCategory(bookCategory) {
                this.book.categories.splice(this.book.categories.indexOf(bookCategory), 1);

                this.categories.forEach(category => {
                    category.id == bookCategory.id ? category.disabled = false : ''
                })
            },
            resetLanguage(bookLanguage) {
                this.book.languages.splice(this.book.languages.indexOf(bookLanguage), 1);

                this.languages.forEach(language => {
                    language.id == bookLanguage.id ? language.disabled = false : ''
                })
            },
            matchAuthors(authors) {
                this.book.authors = authors

            },
            affectArticles(articles) {
                this.book.articles = articles;
            },
            setAvailableDigital() {
                this.availableDigital = !this.availableDigital
                if (!this.availableDigital) {
                    this.digital_name = 'Importer un fichier';
                    this.book.digital_price = '';
                    this.book.digital_link = '';
                    this.freeDigital=false;
                }
            },

            setAvailablePaper() {
                this.availablePaper = !this.availablePaper
                if (!this.availablePaper) {
                    this.book.weight = '';
                    this.book.height = '';
                    this.book.width = '';
                    this.book.thickness = '';
                    this.book.paper_price = '';
                }
            },
            setFreeDigital() {
                this.freeDigital = !this.freeDigital;
                this.freeDigital == true ? this.book.digital_price = '' : ''
            },
            validateData() {
                this.errors = []
                if (this.book.photo == '/img/placeholder.jpg') {
                    this.disabled = false;
                    this.errors.push('Veuillez importer une photo pour le livre');
                    window.scrollTo(0, 0);
                    return;
                }
                if (!this.book.title) {
                    this.disabled = false;
                    this.errors.push('Le titre est requis');
                    window.scrollTo(0, 0);
                    return;
                }
                if (this.book.categories.length == 0) {
                    this.disabled = false;
                    this.errors.push('Veuillez séléctionner au moins une catégorie');
                    window.scrollTo(0, 0);
                    return;
                }

                if (this.book.languages.length == 0) {
                    this.disabled = false;
                    this.errors.push('Veuillez séléctionner au moins une langue');
                    window.scrollTo(0, 0);
                    return;
                }

               

                if (this.book.authors.length == 0) {
                    this.disabled = false;
                    this.errors.push('Veuillez séléctionner au moins un auteur');
                    window.scrollTo(0, 0);
                    return;
                }






                if (!this.book.published_year) {
                    this.disabled = false;
                    this.errors.push('L\'année de publication est requise');
                    window.scrollTo(0, 0);
                    return;
                }

                if (!this.book.editor) {
                    this.disabled = false;
                    this.errors.push('L\'editeur est requis');
                    window.scrollTo(0, 0);
                    return;
                }

                if (!this.book.count_pages) {
                    this.disabled = false;
                    this.errors.push('Le nombre des pages est requis');
                    window.scrollTo(0, 0);
                    return;
                }
                if (this.book.count_pages <= 0) {
                    this.disabled = false;
                    this.errors.push('Le nombre des pages est invalide');
                    window.scrollTo(0, 0);
                    return;
                }

                if (!this.book.isbn) {
                    this.disabled = false;
                    this.errors.push('L\'ISBN est requis');
                    window.scrollTo(0, 0);
                    return;
                }

                if (!this.book.description) {
                    this.errors.push('La description est requise');
                    window.scrollTo(0, 0);
                    return;
                }

                if (!this.availablePaper && !this.availableDigital) {
                    this.disabled = false;

                    this.errors.push('Veuillez séléctionner au moins une version');
                    window.scrollTo(0, 0);
                    return;
                }
                if (this.availableDigital) {
                    if (!this.book.digital_link) {
                        this.disabled = false;
                        this.errors.push('Veuillez importer un fichier pour la vérsion numérique');
                        window.scrollTo(0, 0);
                        return;
                    }
                    if (!this.freeDigital && !this.book.digital_price) {
                        this.disabled = false;
                        this.errors.push('Veuillez spécifier un prix pour la version numerique');
                        window.scrollTo(0, 0);
                        return;

                    }

                }

                if (this.availablePaper) {
                    if (!this.book.height) {
                        this.disabled = false;

                        this.errors.push('L\'hauteur est requise');

                        window.scrollTo(0, 0);
                        return;

                    }
                    if (!this.book.width) {
                        this.disabled = false;
                        this.errors.push('La largeur est requise');

                        window.scrollTo(0, 0);
                        return;

                    }

                    if (!this.book.thickness) {
                        this.disabled = false;

                        this.errors.push('L\'epaisseur est requis');
                        window.scrollTo(0, 0);
                        return;



                    }

                    if (!this.book.weight) {
                        this.disabled = false;
                        this.errors.push('Le poids est requis');
                        window.scrollTo(0, 0);
                        return;
                    }

                    if (!this.book.paper_price) {
                        this.disabled = false;
                        this.errors.push('Le prix est requis');
                        window.scrollTo(0, 0);
                        return;
                    }




                }

                return true;



            },
            submitUpdateBook() {
                this.disabled = true;
                let validate = this.validateData()
                if (validate) {
                   
                    this.$Progress.start()
                    axios.post(`/api/book/${this.book.id}/update`, {
                            book: this.book
                        })
                        .then((response) => {
                            this.$Progress.finish()
                            if (response.data.status == 200) {
                                swal2.fire({
                                    type: 'success',
                                    title: 'Livre modifié avec succés',
                                    allowOutsideClick: false,
                                    showConfirmButton: true,
                                    confirmButtonText: 'Fermer'


                                }).then((result) => {
                                    if (result.value) {
                                        window.location = '/books';
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
            cancelBook()
            {
                window.location = '/books'
            }


        }

    }

</script>
