<template>
    <div class="container-fluid">
        <div class="card card-primary">
            <h3 class=" p-4">Update a article</h3>

            <form role="form">
                <div class="card-body">
                    <show-errors :errors="errors"> </show-errors>
                    <div class="row">
                        <div class="col-md-12">
                            <img :src="article.photo ? article.photo : '/img/placeholder.jpg'"
                                class="rounded mx-auto d-block mb-3 img-upload" style="height:20vh;"
                                @click="$refs.file.click()">
                            <input type="file" ref="file" style="display: none" @change="uploadFile($event,0)">

                        </div>

                    </div>

                    <div class="form-group">
                        <label>Status</label>
                        <select class="form-control" v-model="article.active">
                            <option :value="1">Active</option>
                            <option :value="0">Inactive</option>
                        </select>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <label for="exampleInputEmail1">Title</label>
                            <input type="text" class="form-control" placeholder="article's title.." v-model="article.title">
                        </div>

                    </div>


                 


                    <div class="row mt-3">
                        <div class="col-md-12">
                            <label for="exampleInputEmail1" style="display: block;">Categories</label>
                            <div class="form-group">

                                <select class="form-control" @change="selectCategory($event)">
                                    <option :disabled="article.categories.length > 0"
                                        :selected="article.categories.length == 0">Select categories
                                    </option>
                                    <option :value="category.id" v-for="category in categories"
                                        :disabled="category.disabled">
                                        {{$root.ucfirst(category.name)}}</option>
                                </select>
                            </div>
                            <div class="btn-group mb-3 mt-1 ml-2" v-for="articleCategory in article.categories">
                                <button type="button" class="btn btn-outline-primary">
                                    {{$root.ucfirst(articleCategory.name)}}</button>
                                <button type="button" class="btn btn-outline-primary"
                                    @click="resetCategory(articleCategory)">
                                    <span aria-hidden="true">×</span></button>
                            </div>



                        </div>

                    </div>




                    <div class="row">
                        <div class="col-md-12">
                            <label for="exampleInputEmail1" class="mt-2 mb-2">Published year</label>
                            <input type="number" class="form-control" placeholder="Published year.."
                                v-model="article.published_year">
                        </div>


                    </div>








                    <div class="row mt-3">
                        <div class="col-md-12">
                            <label for="exampleInputEmail1">Description</label>
                            <textarea class="form-control" rows="3" placeholder="Déscription.."
                                v-model="article.description"></textarea>
                        </div>

                    </div>
                    <div class="container mt-4">
                        <div class="form-group mt-2 mb-2">
                            <div class="d-flex flex-row bd-highlight">
                                <div class="p-2 bd-highlight">
                                    <h3 class="font-weight-normal">Import audio file</h3>
                                </div>





                            </div>
                        </div>
                        <div class="rounded-top" style="border: 1px solid #ced4da;">

                            <div class="row" v-if="this.article.audio_link">

                                <div class=" p-4 mx-auto">
                                    <audio width="450" controls
                                        :src="$root.previewBinaryFile(this.article.audio_link)"></audio>

                                </div>

                            </div>
                            <div class="p-4">
                                <div class="input-group mt-2">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="inputGroupFile02"
                                            @change="uploadBinary($event)">
                                        <label class="custom-file-label"
                                            for="inputGroupFile02">{{this.digital_name}}</label>
                                    </div>
                                </div>


                            </div>
                        </div>

                    </div>



                    <show-authors v-if="this.searchedAuthors.length > 0" :authors="this.authors"
                        :oldSearchedAuthors="this.searchedAuthors" v-on:matchAuthors="matchAuthors($event)">
                    </show-authors>
                    <div class="mx-auto mt-4" style="width: 200px;">
                        <div class="row">
                            <a href="/articles" class="btn btn-danger ml-3">Annuler </a>
                            <button type="button" class="btn btn-primary ml-4" @click="submitAddarticle()"
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
            this.formatAuthors()


        },
        props: ['categories', 'authors', 'article_details'],
        data() {
            return {
                digital_name: 'Upload an audio file',

                disabled: false,

                errors: [],
                article: {
                    id: '',
                    active: 1,
                    title: '',
                    categories: [],

                    author_id: '',
                    published_year: '',

                    isbn: '',
                    description: '',


                    photo: '',
                    audio_link: '',


                },
                searchedAuthors: [],
              
            }
        },
        methods: {
            formatCategories() {
                for (let i = 0; i < this.categories.length; i++) {
                    this.$set(this.categories[i], 'disabled', false)

                }
                this.article.id = this.article_details.id
                this.article.active = this.article_details.active
                this.article.title = this.article_details.title
                this.article.categories = this.article_details.categories
                this.article.published_year = this.article_details.published_year
                this.article.isbn = this.article_details.isbn
                this.article.description = this.article_details.description
                this.article.photo = this.article_details.photo
                this.article.author_id = this.article_details.author_id
                this.article.audio_link = this.article_details.audio_link
            },
            formatAuthors() {
                if (this.authors && this.authors.length > 0) {

                    this.authors.forEach(oldAuthor => {
                        if (oldAuthor.id == this.article.author_id)
                            this.searchedAuthors.push({
                                id: oldAuthor.id,
                                fullName: oldAuthor.first_name + ' ' + oldAuthor.last_name,
                                biography: oldAuthor.biography,
                                photo: oldAuthor.photo,
                                selected: true,

                            })



                    })


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
                        this.article.audio_link = file.link
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

            uploadBinary(event) {


                let file = this.$root.uploadBinary(event);
                if (file) {

                    this.article.audio_link = file
                    this.digital_name = file.name
                    return;

                }



                swal2.fire({
                    type: 'error',
                    title: 'Format fichier non supporté',
                    allowOutsideClick: false,
                    showConfirmButton: true,
                    confirmButtonText: 'Fermer'


                });














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
            matchAuthors(authorId) {
                this.article.author_id = authorId

            },



            validateData() {
                this.errors = []
                if (this.article.photo == '/img/placeholder.jpg') {
                    this.disabled = false;
                    this.errors.push('Photo is required');
                    window.scrollTo(0, 0);
                    return;
                }
                if (!this.article.title) {
                    this.disabled = false;
                    this.errors.push('Title is required');
                    window.scrollTo(0, 0);
                    return;
                }


                if (!this.article.isbn) {
                    this.disabled = false;
                    this.errors.push('ISBN is required');
                    window.scrollTo(0, 0);
                    return;
                }
                if (this.article.categories.length == 0) {
                    this.disabled = false;
                    this.errors.push('Please select a category');
                    window.scrollTo(0, 0);
                    return;
                }

                if (!this.article.published_year) {
                    this.disabled = false;
                    this.errors.push('Published year is required');
                    window.scrollTo(0, 0);
                    return;
                }




                if (!this.article.description) {
                    this.disabled = false;
                    this.errors.push('La description est requise');
                    window.scrollTo(0, 0);
                    return;
                }





                if (!this.article.audio_link) {
                    this.disabled = false;
                    this.errors.push('Please import an audio file');
                    window.scrollTo(0, 0);
                    return;
                }


                if (!this.article.author_id) {
                    this.disabled = false;
                    this.errors.push('Please select an author');
                    window.scrollTo(0, 0);
                    return;
                }



                return true;



            },
            submitAddarticle() {
                this.disabled = true;
                let validate = this.validateData()
                if (validate) {
                    this.$Progress.start()
                    let body = new FormData()

                    body.append('id', this.article.id)
                    body.append('photo', this.article.photo)
                    if (typeof this.article.audio_link === 'object') {
                        body.append('audio_link', this.article.audio_link)
                        //audio file has to be a type of file
                    }

                    body.append('categories', JSON.stringify(this.article.categories))
                    body.append('title', this.article.title)
                    body.append('active', this.article.active)
                    body.append('description', this.article.description)
                    body.append('isbn', this.article.isbn)
                    body.append('published_year', this.article.published_year)
                    body.append('author_id', this.article.author_id)




                    axios.post(`/api/article/${this.article.id}/update`, body)
                        .then((response) => {
                            this.$Progress.finish()
                            if (response.data.status == 200) {
                                swal2.fire({
                                    type: 'success',
                                    title: 'article updated',
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



        }

    }

</script>
