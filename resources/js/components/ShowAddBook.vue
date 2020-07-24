<template>
    <div class="container-fluid">
        <div class="card card-primary">
            <vue-element-loading :active="isActive" spinner="bar-fade-scale" color="#FF6700" size="100"
                :text="'Uploading '+percentage+' %'" :is-full-screen="true" />
            <h3 class=" p-4">Add a book</h3>

            <form role="form">
                <div class="card-body">
                    <show-errors :errors="errors"> </show-errors>
                    <div class="row">
                        <div class="col-md-12">
                            <img :src="book.photo ? book.photo : '/img/placeholder.jpg'"
                                class="rounded mx-auto d-block mb-3 img-upload" style="height:20vh;"
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
                            <input type="text" class="form-control" placeholder="Title.." v-model="book.title">
                        </div>

                    </div>


                    <div class="row mt-3">
                        <div class="col-md-12">
                            <label for="exampleInputEmail1">Subject</label>

                            <vue-editor ref="vue-editor-quill" v-model="book.subject"></vue-editor>
                        </div>

                    </div>

                    <div class="row mt-3">
                        <div class="col-md-12">
                            <label for="exampleInputEmail1">Why to read</label>

                            <vue-editor ref="vue-editor-quill" v-model="book.why_to_read"></vue-editor>



                        </div>


                    </div>


                    <div class="row mt-3">
                        <div class="col-md-12">
                            <label for="exampleInputEmail1">Quotes</label>

                            <vue-editor ref="vue-editor-quill" v-model="book.quotes"></vue-editor>



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



                    <div class="container mt-4">
                        <div class="form-group mt-2 mb-2">
                            <div class="d-flex flex-row bd-highlight">
                                <div class="p-2 bd-highlight">
                                    <h3 class="font-weight-normal">Import pdf file</h3>
                                </div>





                            </div>
                        </div>
                        <div class="rounded-top" style="border: 1px solid #ced4da;">

                            <div class="row" v-if="book.pdf_link">

                                <div class="p-4 mx-auto">

                                    <embed :src="$root.previewBinaryFile(this.book.pdf_link,1)" width="500" height="375"
                                        type="application/pdf">
                                </div>

                            </div>
                            <div class="p-4">
                                <div class="input-group mt-2">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="inputGroupFile02"
                                            @change="uploadBinary($event,1)">
                                        <label class="custom-file-label" for="inputGroupFile02">{{pdf_name}}</label>
                                    </div>
                                </div>


                            </div>
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

                                    <audio width="450" controls
                                        :src="$root.previewBinaryFile(this.book.audio_link,2)"></audio>
                                </div>

                            </div>
                            <div class="p-4">
                                <div class="input-group mt-2">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="inputGroupFile02"
                                            @change="uploadBinary($event,2)">
                                        <label class="custom-file-label" for="inputGroupFile02">{{digital_name}}</label>
                                    </div>
                                </div>


                            </div>
                        </div>

                    </div>

                    <show-nested-collections :collections="this.collections"
                        v-on:submitCollections="submitCollections($event)"> </show-nested-collections>

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
    import ShowNestedCollections from './nested/ShowNestedCollections.vue'
    import ShowErrors from './nested/ShowErrors.vue'
    // Basic Use - Covers most scenarios
    import {
        VueEditor
    } from "vue2-editor";

    export default {
        mounted() {
            this.formatCategories()
            this.$refs['vue-editor-quill'].quill.format('direction', 'rtl');
            this.$refs['vue-editor-quill'].quill.format('align', 'right');


        },
        props: ['categories', 'authors', 'collections'],
        data() {
            return {
                digital_name: 'Upload an audio file',
                pdf_name: 'Upload a pdf file',
                disabled: false,
                isActive: false,
                percentage: 0,

                errors: [],
                book: {
                    active: 1,
                    title: '',
                    categories: [],
                    collections: [],
                    author_id: '',
                    subject: '',

                    why_to_read: '',
                    description: '',


                    photo: '',
                    audio_link: '',
                    pdf_link: '',

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
                    icon: 'error',
                    title: 'File not supported',
                    allowOutsideClick: false,
                    showConfirmButton: true,
                    confirmButtonText: 'Fermer'


                });
                return;









            },

            uploadBinary(event, type) {


                let file = this.$root.uploadBinary(event, type);
                if (file) {
                    if (type == 1) {
                        this.book.pdf_link = file
                        this.pdf_name = file.name
                        return;

                    } else {
                        this.book.audio_link = file
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

            submitCollections(collections) {

                this.book.collections = collections


            },



            validateData() {
                this.disabled = true;
                this.errors = []
                if (!this.book.photo) {

                    this.errors.push('Photo is required');
                    window.scrollTo(0, 0);
                    this.disabled = false;
                    return;
                }
                if (!this.book.title) {
                    this.disabled = false;
                    this.errors.push('Title is required');
                    window.scrollTo(0, 0);
                    return;
                }


                if (!this.book.subject) {
                    this.disabled = false;
                    this.errors.push('subject is required');
                    window.scrollTo(0, 0);
                    return;
                }


                if (!this.book.why_to_read) {
                    this.disabled = false;
                    this.errors.push('Why to read  is required');
                    window.scrollTo(0, 0);
                    return;
                }



                if (!this.book.quotes) {
                    this.disabled = false;
                    this.errors.push('Quotes  is required');
                    window.scrollTo(0, 0);
                    return;
                }
                if (this.book.categories.length == 0) {
                    this.disabled = false;
                    this.errors.push('Please select a category');
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
                let validate = this.validateData()


                if (validate) {
                    this.isActive = true;
                    let body = new FormData()


                    body.append('photo', this.book.photo)
                    body.append('audio_link', this.book.audio_link)
                    body.append('pdf_link', this.book.pdf_link)
                    body.append('categories', JSON.stringify(this.book.categories))
                    if (this.book.collections.length > 0) {
                        body.append('collections', JSON.stringify(this.book.collections))
                    }

                    body.append('title', this.book.title)
                    body.append('active', this.book.active)
                    body.append('why_to_read', this.book.why_to_read)
                    body.append('subject', this.book.subject)
                    body.append('quotes', this.book.quotes)
                    body.append('author_id', this.book.author_id)



                    let config = {
                        onUploadProgress: progressEvent => {
                            let progress = Math.round((progressEvent.loaded * 100) / progressEvent.total)

                            this.percentage = progress
                        }
                    }

                    axios.post('/api/book/save', body, config)
                        .then((response) => {
                            this.isActive = false;

                            if (response.data.status == 200) {

                                swal2.fire({
                                    icon: 'success',
                                    title: 'Book added',
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
                            this.isActive = false;
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
