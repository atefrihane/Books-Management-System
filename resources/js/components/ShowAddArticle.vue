<template>
    <div class="container-fluid">
        <div class="card card-primary">
            <vue-element-loading :active="isActive" spinner="bar-fade-scale" color="#FF6700" size="100"
                :text="'Uploading '+percentage+' %'" :is-full-screen="true" />
            <h3 class=" p-4">Add an article</h3>

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
                            <input type="text" class="form-control" placeholder="article's title.."
                                v-model="article.title">
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






                    <div class="row mt-3">
                        <div class="col-md-12">
                            <label for="exampleInputEmail1">Writing date</label>
                            <input class="form-control" type="date" v-model="article.writing_date"
                                placeholder="Writing date">
                        </div>

                    </div>

                    <div class="row mt-3">
                        <div class="col-md-12">
                            <label for="exampleInputEmail1">Published date</label>
                            <input class="form-control" type="date" v-model="article.published_date"
                                placeholder="Published date">
                        </div>

                    </div>

                    <div class="row mt-3">
                        <div class="col-md-12">
                            <label for="exampleInputEmail1">Content</label>
                            <vue-editor ref="content" v-model="article.content"></vue-editor>
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



                    <show-authors :authors="this.authors" v-on:matchAuthors="matchAuthors($event)"> </show-authors>
                    <div class="mx-auto mt-4" style="width: 200px;">
                        <div class="row">
                            <a href="/articles" class="btn btn-danger ml-3">Cancel </a>
                            <button type="button" class="btn btn-primary ml-4" @click="submitAddarticle()"
                                :disabled="disabled">Confirm</button>
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
    //    import VueElementLoading from 'vue-element-loading'

    // Basic Use - Covers most scenarios
    import {
        VueEditor
    } from "vue2-editor";

    export default {

        mounted() {
            this.formatCategories()
 this.$refs['content'].quill.format('align', 'right');

        },
        props: ['categories', 'authors'],
        data() {
            return {
                digital_name: 'Upload an audio file',
                pdf_name: 'Upload a pdf file',
                disabled: false,
                isActive: false,
                percentage: 0,

                errors: [],
                article: {
                    active: 1,
                    title: '',
                    categories: [],
                    author_id: '',

                    writing_date: '',

                    published_date: '',
                    photo: '',
                    audio_link: '',
                    pdf_link: '',
                    content: ''

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
                        this.article.photo = file.link

                        return;
                    } else {
                        this.article.audio_link = file.link
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
                        this.article.pdf_link = file
                        this.pdf_name = file.name
                        return;

                    } else {
                        this.article.audio_link = file
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
                if (!this.article.photo) {
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



                if (this.article.categories.length == 0) {
                    this.disabled = false;
                    this.errors.push('Please select a category');
                    window.scrollTo(0, 0);
                    return;
                }






                if (!this.article.writing_date) {
                    this.disabled = false;
                    this.errors.push('Writing date required');
                    window.scrollTo(0, 0);
                    return;
                }

                if (!this.article.published_date) {
                    this.disabled = false;
                    this.errors.push('Published  date required');
                    window.scrollTo(0, 0);
                    return;
                }

                if (!this.article.content) {
                    this.disabled = false;
                    this.errors.push('Content date required');
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
                    this.isActive = true;
                    let body = new FormData()


                    body.append('photo', this.article.photo)
                    body.append('audio_link', this.article.audio_link)
                    body.append('pdf_link', this.article.pdf_link)
                    body.append('categories', JSON.stringify(this.article.categories))
                    body.append('title', this.article.title)
                    body.append('active', this.article.active)

                    body.append('writing_date', this.article.writing_date)
                    body.append('published_date', this.article.published_date)
                    body.append('content', this.article.content)
                    body.append('author_id', this.article.author_id)


                    let config = {
                        onUploadProgress: progressEvent => {
                            let progress = Math.round((progressEvent.loaded * 100) / progressEvent.total)

                            this.percentage = progress
                        }
                    }


                    axios.post('/api/article/save', body, config)
                        .then((response) => {
                            this.isActive = false;
                            if (response.data.status == 200) {
                                swal2.fire({
                                    icon: 'success',
                                    title: 'Article added successfuly',
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
