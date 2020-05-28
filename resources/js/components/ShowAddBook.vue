<template>
    <div class="container-fluid">
        <div class="card card-primary">
            <h3 class=" p-4">Add a book</h3>

            <form role="form">
                <div class="card-body">
                    <show-errors :errors="errors"> </show-errors>
                    <div class="row">
                        <div class="col-md-12">
                            <img :src="book.photo" class="rounded mx-auto d-block mb-3 img-upload" style="height:20vh;"
                                @click="$refs.file.click()">
                            <input type="file" ref="file" style="display: none" @change="uploadFile($event,0)">

                        </div>

                    </div>

                    <div class="form-group">
                        <label>Status</label>
                        <select class="form-control" v-model="book.active">
                            <option :value="1">Active</option>
                            <option :value="0">Inactive</option>
                        </select>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <label for="exampleInputEmail1">Title</label>
                            <input type="text" class="form-control" placeholder="Book's title.." v-model="book.title">
                        </div>

                    </div>


                    <div class="row mt-3">
                        <div class="col-md-12">
                            <label for="exampleInputEmail1">ISBN</label>
                            <input type="text" class="form-control" placeholder="Book's isbn.." v-model="book.isbn">
                        </div>

                    </div>


                    <div class="row mt-3">
                        <div class="col-md-12">
                            <label for="exampleInputEmail1" style="display: block;">Categories</label>
                            <div class="form-group">

                                <select class="form-control" @change="selectCategory($event)">
                                    <option :disabled="book.categories.length > 0"
                                        :selected="book.categories.length == 0">Select categories
                                    </option>
                                    <option :value="category.id" v-for="category in categories"
                                        :disabled="category.disabled">
                                        {{$root.ucfirst(category.name)}}</option>
                                </select>
                            </div>
                            <div class="btn-group mb-3 mt-1 ml-2" v-for="bookCategory in book.categories">
                                <button type="button" class="btn btn-outline-primary">
                                    {{$root.ucfirst(bookCategory.name)}}</button>
                                <button type="button" class="btn btn-outline-primary"
                                    @click="resetCategory(bookCategory)">
                                    <span aria-hidden="true">×</span></button>
                            </div>



                        </div>

                    </div>




                    <div class="row">
                        <div class="col-md-12">
                            <label for="exampleInputEmail1" class="mt-2 mb-2">Published year</label>
                            <input type="number" class="form-control" placeholder="Published year.."
                                v-model="book.published_year">
                        </div>


                    </div>








                    <div class="row mt-3">
                        <div class="col-md-12">
                            <label for="exampleInputEmail1">Description</label>
                            <textarea class="form-control" rows="3" placeholder="Déscription.."
                                v-model="book.description"></textarea>
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

                            <div class="row" v-if="book.audio_link">

                                <div class="p-4 mx-auto">

                                    <audio controls>

                                        <source :src="$root.previewBinaryFile(book.audio_link)" type="audio/mpeg">
                                        Your browser does not support the audio element.
                                    </audio>
                                </div>

                            </div>
                            <div class="p-4">
                                <div class="input-group mt-2">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="inputGroupFile02"
                                            @change="uploadBinary($event)">
                                        <label class="custom-file-label" for="inputGroupFile02">{{digital_name}}</label>
                                    </div>
                                </div>


                            </div>
                        </div>

                    </div>



                    <show-authors :authors="this.authors" v-on:matchAuthors="matchAuthors($event)"> </show-authors>
                    <div class="mx-auto mt-4" style="width: 200px;">
                        <div class="row">
                            <a href="/books" class="btn btn-danger ml-3">Annuler </a>
                            <button type="button" class="btn btn-primary ml-4" @click="submitAddBook()"
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


        },
        props: ['categories', 'authors'],
        data() {
            return {
                digital_name: 'Upload an audio  file',

                disabled: false,

                errors: [],
                book: {
                    active: 1,
                    title: '',
                    categories: [],

                    author_id: '',
                    published_year: '',

                    isbn: '',
                    description: '',


                    photo: '/img/placeholder.jpg',
                    audio_link: '',


                }

            }
        },
        methods: {
            formatCategories() {
                for (let i = 0; i < this.categories.length; i++) {
                    this.$set(this.categories[i], 'disabled', false)

                }

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
                        this.book.audio_link = file.link
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

                    this.book.audio_link = file
                    this.digital_name = file.name


                }





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
                    this.defaultCategorySelection


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
            matchAuthors(authorId) {
                this.book.author_id = authorId

            },



            validateData() {
                this.errors = []
                if (this.book.photo == '/img/placeholder.jpg') {
                    this.disabled = false;
                    this.errors.push('Photo is required');
                    window.scrollTo(0, 0);
                    return;
                }
                if (!this.book.title) {
                    this.disabled = false;
                    this.errors.push('Title is required');
                    window.scrollTo(0, 0);
                    return;
                }


                if (!this.book.isbn) {
                    this.disabled = false;
                    this.errors.push('ISBN is required');
                    window.scrollTo(0, 0);
                    return;
                }
                if (this.book.categories.length == 0) {
                    this.disabled = false;
                    this.errors.push('Please select a category');
                    window.scrollTo(0, 0);
                    return;
                }

                if (!this.book.published_year) {
                    this.disabled = false;
                    this.errors.push('Published year is required');
                    window.scrollTo(0, 0);
                    return;
                }




                if (!this.book.description) {
                    this.disabled = false;
                    this.errors.push('La description est requise');
                    window.scrollTo(0, 0);
                    return;
                }





                if (!this.book.audio_link) {
                    this.disabled = false;
                    this.errors.push('Please import an audio file');
                    window.scrollTo(0, 0);
                    return;
                }


                if (!this.book.author_id) {
                    this.disabled = false;
                    this.errors.push('Please select an author');
                    window.scrollTo(0, 0);
                    return;
                }



                return true;



            },
            submitAddBook() {
                this.disabled = true;
                let validate = true
                if (validate) {
                    this.$Progress.start()
                  let body =new FormData()
                  let categoriesIds = [];
               
                    body.append('photo', this.book.photo)
                    body.append('audio_link', this.book.audio_link)
                    body.append('categories', JSON.stringify(this.book.categories))
                    body.append('title', this.book.title)
                    body.append('active', this.book.active)
                    body.append('description', this.book.description)
                    body.append('isbn', this.book.isbn)
                    body.append('published_year', this.book.published_year)

                   



                    axios.post('/api/book/save',body)
                        .then((response) => {
                            this.$Progress.finish()
                            if (response.data.status == 200) {
                                swal2.fire({
                                    type: 'success',
                                    title: 'Livre ajouté avec succés',
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
           


        }

    }

</script>
