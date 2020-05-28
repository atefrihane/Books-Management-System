<template>
    <div class="container-fluid">
        <div class="card card-primary">
            <h3 class=" p-4">Ajouter un article</h3>

            <form role="form">
                <div class="card-body">
                    <show-errors :errors="errors"> </show-errors>
                    <div class="row">
                        <div class="col-md-12">
                            <img :src="article.photo" class="rounded mx-auto d-block mb-3 img-upload" style="height:20vh;"
                                @click="$refs.file.click()">
                            <input type="file" ref="file" style="display: none" @change="uploadFile($event,0)">

                        </div>

                    </div>

                    <div class="form-group">
                        <label>Etat</label>
                        <select class="form-control" v-model="article.active">
                            <option :value="1">Actf</option>
                            <option :value="0">Inactif</option>
                        </select>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <label for="exampleInputEmail1">Titre</label>
                            <input type="text" class="form-control" placeholder="Titre.." v-model="article.title">
                        </div>

                    </div>


                    <div class="row mt-3">
                        <div class="col-md-6">
                            <label for="exampleInputEmail1" style="display: block;">Catégories</label>
                            <div class="form-group">

                                <select class="form-control" @change="selectCategory($event)">
                                    <option :disabled="article.categories.length > 0"
                                        :selected="article.categories.length == 0">Selectionner une catégorie
                                    </option>
                                    <option :value="category.id" v-for="category in categories"
                                        :disabled="category.disabled">
                                        {{$root.ucfirst(category.name)}}</option>
                                </select>
                            </div>
                            <div class="btn-group mb-3 mt-1 ml-2" v-for="articleCategory in article.categories">
                                <button type="button" class="btn btn-outline-primary"> {{$root.ucfirst(articleCategory.name)}}</button>
                                <button type="button" class="btn btn-outline-primary"
                                    @click="resetCategory(articleCategory)">
                                    <span aria-hidden="true">×</span></button>
                            </div>



                        </div>
                        <div class="col-md-6">
                            <label for="exampleInputEmail1" style="display: block;">Langues</label>
                            <div class="form-group">

                                <select class="form-control" @change="selectLanguage($event)">
                                    <option :selected="article.languages.length == 0"
                                        :disabled="article.languages.length > 0">Selectionner une langue
                                    </option>
                                    <option :value="language.id" v-for="language in languages"
                                        :disabled="language.disabled">
                                      {{$root.ucfirst(language.name)}}</option>

                                </select>
                            </div>
                            <div class="btn-group mb-3 m-1" v-if="article.languages.length >  0"
                                v-for="articleLanguage in article.languages">
                                <button type="button" class="btn btn-outline-secondary"> {{$root.ucfirst(articleLanguage.name)}}</button>
                                <button type="button" class="btn btn-outline-secondary"
                                    @click="resetLanguage(articleLanguage)">
                                    <span aria-hidden="true">×</span></button>
                            </div>



                        </div>
                    </div>




                    <div class="row">
                        <div class="col-md-6">
                            <label for="exampleInputEmail1" class="mt-2 mb-2">Année de publication</label>
                            <input type="number" class="form-control" placeholder="Année de publication.."
                                v-model="article.published_year">
                        </div>
                        <div class="col-md-6">
                            <label for="exampleInputEmail1" class="mt-2">Editeur</label>
                            <input type="text" class="form-control" placeholder="Editeur.." v-model="article.editor">

                        </div>

                    </div>




                    <div class="row mt-3">
                        <div class="col-md-6">
                            <label for="exampleInputEmail1">Nombre de pages</label>
                            <input type="number" class="form-control" placeholder="Nombre de pages.."
                                v-model="article.count_pages">
                        </div>
                        <div class="col-md-6">
                            <label for="exampleInputEmail1">ISBN</label>
                            <input type="text" class="form-control" placeholder="ISBN.." v-model="article.isbn">

                        </div>

                    </div>



                    <div class="row mt-3">
                        <div class="col-md-12">
                            <label for="exampleInputEmail1">Déscription</label>
                            <textarea class="form-control" rows="3" placeholder="Déscription.."
                                v-model="article.description"></textarea>
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

                            <div class="row" v-if="article.digital_link && this.digital_name!='Importer un fichier'">
                                <iframe :src="article.digital_link" class="mx-auto m-3" style="width:600px; height:500px;"
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
                                    <div class="col-md-6 mb-2"> 
                                    
                                    <input type="number" class="form-control"
                                            placeholder="Prix.." v-model="article.digital_price"
                                            :disabled="freeDigital || !availableDigital"></div>
                                    <div class="col-md-6">
                                        <div class="form-check mt-1">
                                            <input class="form-check-input" type="checkbox"
                                                :disabled="!availableDigital" @click="setFreeDigital()">
                                            <h5>Gratuit à télécharger</h5>
                                        </div>
                                    </div>

                                </div>


                            </div>
                        </div>

                    </div>
             


                    <show-authors :authors="this.authors" v-on:matchAuthors="matchAuthors($event)"> </show-authors>
                    <div class="mx-auto mt-4" style="width: 200px;">
                        <div class="row">
                            <button type="button" class="btn btn-danger ml-3" @click="cancelArticle()">Annuler</button>
                            <button type="button" class="btn btn-primary ml-4" @click="submitAddArticle()"
                                :disabled="disabled">Confirmer</button>
                        </div>
                    </div>

                </div>
            </form>




        </div>


    </div>
</template>

<script>
  
    import ShowAuthors from './nested/ShowAuthors.vue'
    import ShowErrors from './nested/ShowErrors.vue'
    export default {
        mounted() {
            this.formatCategories()
            this.formatLanguages()

        },
        props: ['languages', 'categories', 'articles', 'authors'],
        data() {
            return {
                digital_name: 'Importer un fichier',
                availablePaper: false,
                availableDigital: false,
                disabled: false,
                freeDigital: false,
                errors: [],
                article: {
                    active: 1,
                    title: '',
                    categories: [],
                    languages: [],
                    authors: [],
                    published_year: '',
                    editor: '',
                    count_pages: '',
                    isbn: '',
                    description: '',
                    isbn: '',
                    digital_price: '',
                    photo: '/img/placeholder.jpg',
                    digital_link: '',


                }

            }
        },
        methods: {
            formatCategories() {
                for (let i = 0; i < this.categories.length; i++) {
                    this.$set(this.categories[i], 'disabled', false)

                }

            },
            formatLanguages() {
                for (let i = 0; i < this.languages.length; i++) {
                    this.$set(this.languages[i], 'disabled', false)

                }

            },
            async uploadFile(event, type) {
                // 0 image
                // 1 pdf

                let file = await this.$root.uploadFile(event, type);
                if (file) {
                    if (type == 0) {
                        this.article.photo = file.link

                        return;
                    } else {
                        this.article.digital_link = file.link
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
                    this.article.categories.push(checkValue)


                    this.categories.forEach(category => {
                        category.id == id ? category.disabled = true : ''
                    })
                    this.defaultCategorySelection


                }




            },
            selectLanguage(event) {
                let id = event.target.value;
                if (id) {
                    let checkValue = _.find(this.languages, function (o) {
                        return o.id == id;
                    });
                    this.article.languages.push(checkValue)


                    this.languages.forEach(language => {
                        language.id == id ? language.disabled = true : ''
                    })


                }


            },
            resetCategory(articleCategory) {
                this.article.categories.splice(this.article.categories.indexOf(articleCategory), 1);

                this.categories.forEach(category => {
                    category.id == articleCategory.id ? category.disabled = false : ''
                })
            },
            resetLanguage(articleLanguage) {
                this.article.languages.splice(this.article.languages.indexOf(articleLanguage), 1);

                this.languages.forEach(language => {
                    language.id == articleLanguage.id ? language.disabled = false : ''
                })
            },
            matchAuthors(authors) {
                this.article.authors = authors

            },
            affectArticles(articles) {
                this.article.articles = articles;
            },
            setAvailableDigital() {
                this.availableDigital = !this.availableDigital
                if (!this.availableDigital) {
                    this.digital_name = 'Importer un fichier';
                    this.article.digital_price = '';
                }
            },

            setAvailablePaper() {
                this.availablePaper = !this.availablePaper
                if (!this.availablePaper) {
                    this.article.weight = '';
                    this.article.height = '';
                    this.article.width = '';
                    this.article.thickness = '';
                    this.article.paper_price = '';
                }
            },
            setFreeDigital() {
                this.freeDigital = !this.freeDigital;
                this.freeDigital == true ? this.article.digital_price = '' : ''
            },
            validateData() {
                this.errors = []
                if (this.article.photo == '/img/placeholder.jpg') {
                    this.disabled = false;
                    this.errors.push('Veuillez importer une photo pour le livre');
                    window.scrollTo(0, 0);
                    return;
                }
                if (!this.article.title) {
                    this.disabled = false;
                    this.errors.push('Le titre est requis');
                    window.scrollTo(0, 0);
                    return;
                }
                if (this.article.categories.length == 0) {
                    this.disabled = false;
                    this.errors.push('Veuillez séléctionner au moins une catégorie');
                    window.scrollTo(0, 0);
                    return;
                }

                if (this.article.languages.length == 0) {
                    this.disabled = false;
                    this.errors.push('Veuillez séléctionner au moins une langue');
                    window.scrollTo(0, 0);
                    return;
                }

             
                if (this.article.authors.length == 0) {
                    this.disabled = false;
                    this.errors.push('Veuillez séléctionner au moins un auteur');
                    window.scrollTo(0, 0);
                    return;
                }






                if (!this.article.published_year) {
                    this.disabled = false;
                    this.errors.push('L\'année de publication est requise');
                    window.scrollTo(0, 0);
                    return;
                }

                if (!this.article.editor) {
                    this.disabled = false;
                    this.errors.push('L\'editeur est requis');
                    window.scrollTo(0, 0);
                    return;
                }

                if (!this.article.count_pages) {
                    this.disabled = false;
                    this.errors.push('Le nombre des pages est requis');
                    window.scrollTo(0, 0);
                    return;
                }
          

                if (!this.article.isbn) {
                    this.disabled = false;
                    this.errors.push('L\'ISBN est requis');
                    window.scrollTo(0, 0);
                    return;
                }

                if (!this.article.description) {
                       this.disabled = false;
                    this.errors.push('La description est requise');
                    window.scrollTo(0, 0);
                    return;
                }

            
                if (this.availableDigital) {
                    if (!this.article.digital_link) {
                        this.disabled = false;
                        this.errors.push('Veuillez importer un fichier pour la vérsion numérique');
                        window.scrollTo(0, 0);
                        return;
                    }
                    if (!this.freeDigital && !this.article.digital_price) {
                        this.disabled = false;
                        this.errors.push('Veuillez spécifier un prix pour la version numerique');
                        window.scrollTo(0, 0);
                        return;

                    }

                }

                if (this.availablePaper) {
                    if (!this.article.height) {
                        this.disabled = false;

                        this.errors.push('L\'hauteur est requise');

                        window.scrollTo(0, 0);
                        return;

                    }
                    if (!this.article.width) {
                        this.disabled = false;
                        this.errors.push('La largeur est requise');

                        window.scrollTo(0, 0);
                        return;

                    }

                    if (!this.article.thickness) {
                        this.disabled = false;

                        this.errors.push('L\'epaisseur est requis');
                        window.scrollTo(0, 0);
                        return;



                    }

                    if (!this.article.weight) {
                        this.disabled = false;
                        this.errors.push('Le poids est requis');
                        window.scrollTo(0, 0);
                        return;
                    }

                    if (!this.article.paper_price) {
                        this.disabled = false;
                        this.errors.push('Le prix est requis');
                        window.scrollTo(0, 0);
                        return;
                    }




                }

                return true;



            },
            submitAddArticle() {
                this.disabled = true;
                let validate = this.validateData()

                
                if (validate) {
       
                      this.$Progress.start()
                    axios.post('/api/article/save', {
                            article: this.article
                        })
                        .then((response) => {
                              this.$Progress.finish()
                            if (response.data.status == 200) {
                                swal2.fire({
                                    type: 'success',
                                    title: 'Article ajouté avec succés',
                                    allowOutsideClick: false,
                                    showConfirmButton: true,
                                    confirmButtonText: 'Fermer'


                                }).then((result) => {
                                    if (result.value) {
                                        window.location = '/articles';
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
             cancelArticle()
            {
                window.location='/articles'
            }


        }

    }

</script>
