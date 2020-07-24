<template>
    <div class="container-fluid">
        <div class="card card-primary">
            <vue-element-loading :active="isActive" spinner="bar-fade-scale" color="#FF6700" size="100"
                :text="'Uploading '+percentage+' %'" :is-full-screen="true" />
            <h3 class=" p-4">Add a collection</h3>

            <form role="form">
                <div class="card-body">
                    <show-errors :errors="errors"> </show-errors>
                    <div class="row">
                        <div class="col-md-12">
                            <img :src="collection.photo ? collection.photo : '/img/placeholder.jpg'"
                                class="rounded mx-auto d-block mb-3 img-upload" style="height:20vh;"
                                @click="$refs.file.click()">
                            <input type="file" ref="file" style="display: none" @change="uploadFile($event,0)">

                        </div>

                    </div>

                 
                    <div class="row">
                        <div class="col-md-12">
                            <label for="exampleInputEmail1">Name</label>
                            <input type="text" class="form-control" placeholder="name.." v-model="collection.name">
                        </div>

                    </div>


        
                    <div class="mx-auto mt-4" style="width: 200px;">
                        <div class="row">
                            <a href="/collections" class="btn btn-danger ml-3">Cancel </a>
                            <button type="button" class="btn btn-primary ml-4" @click="submitAddCollection()"
                                :disabled="disabled">Confirm</button>
                        </div>
                    </div>

                </div>
            </form>




        </div>


    </div>
</template>

<script>

    import ShowErrors from './nested/ShowErrors.vue'
    // Basic Use - Covers most scenarios
    import {
        VueEditor
    } from "vue2-editor";

    export default {
        mounted() {
     


        },
        props: ['categories', 'authors'],
        data() {
            return {
            
                disabled: false,
                isActive: false,
                percentage: 0,

                errors: [],
                collection: {
             
                    name: '',
                    photo: '',

          


                }

            }
        },
        methods: {
        

            async uploadFile(event, type) {
                // 0 image
                // 1 pdf

                let file = await this.$root.uploadFile(event, type);
              
                if (file) {

                    if (type == 0) {
             
                        this.collection.photo = file.link

                        return;
                    }


                }




                swal2.fire({
                    icon: 'error',
                    name: 'File not supported',
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
                        this.collection.pdf_link = file
                        this.pdf_name = file.name
                        return;

                    } 

                }



                swal2.fire({
                    icon: 'error',
                    name: 'File not supported',
                    allowOutsideClick: false,
                    showConfirmButton: true,
                    confirmButtonText: 'Fermer'


                });





            },

       
      
        

            validateData() {
                this.disabled = true;
                this.errors = []
                if (!this.collection.photo) {

                    this.errors.push('Photo is required');
                    window.scrollTo(0, 0);
                    this.disabled = false;
                    return;
                }
                if (!this.collection.name) {
                    this.disabled = false;
                    this.errors.push('name is required');
                    window.scrollTo(0, 0);
                    return;
                }









                return true;



            },
            submitAddCollection() {
                let validate = this.validateData()


                if (validate) {
                    this.isActive = true;
                    let body = new FormData()


                    body.append('photo', this.collection.photo)
                    body.append('name', this.collection.name)
             



                    let config = {
                        onUploadProgress: progressEvent => {
                            let progress = Math.round((progressEvent.loaded * 100) / progressEvent.total)

                            this.percentage = progress
                        }
                    }

                    axios.post('/api/collections/add', body, config)
                        .then((response) => {
                            this.isActive = false;

                            if (response.data.status == 200) {

                                swal2.fire({
                                    icon: 'success',
                                    title: 'Collection created',
                                    allowOutsideClick: false,
                                    showConfirmButton: true,
                                    confirmButtonText: 'Fermer'


                                }).then((result) => {

                                    if (result.value) {
                                        window.location = '/collections';
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
