<template>
    <div class="container-fluid">
        <div class="card card-primary">
            <vue-element-loading :active="isActive" spinner="bar-fade-scale" color="#FF6700" size="100"
                :text="'Uploading '+percentage+' %'" :is-full-screen="true" />
            <h3 class=" p-4">Update a category</h3>

            <form role="form">
                <div class="card-body">
                    <show-errors :errors="errors"> </show-errors>



                    <div class="row">
                        <div class="col-md-12">
                            <label for="exampleInputEmail1">Name</label>
                            <input type="text" class="form-control" placeholder="Name.." v-model="name">
                        </div>

                    </div>

                    <div class="mx-auto mt-4" style="width: 200px;">
                        <div class="row">
                            <a href="/categories" class="btn btn-danger ml-3">Cancel </a>
                            <button type="button" class="btn btn-primary ml-4" @click="submitAddCategory()"
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

    export default {

        mounted() {



        },
        props: ['category'],
        data() {
            return {
                id: this.category.id,
                name: this.category.name,
                percentage: '',
                isActive: false,
                errors: [],
                disabled: false


            }
        },
        methods: {




            validateData() {
                this.errors = []

                if (!this.name) {
                    this.disabled = false;
                    this.errors.push('Name is required');
                    window.scrollTo(0, 0);
                    return;
                }


                return true;



            },
            submitAddCategory() {
                this.disabled = true;

                let validate = this.validateData()
                if (validate) {
                    this.isActive = true;
                    let body = new FormData()

                    body.append('id', this.id)
                    body.append('name', this.name)



                    let config = {
                        onUploadProgress: progressEvent => {
                            let progress = Math.round((progressEvent.loaded * 100) / progressEvent.total)

                            this.percentage = progress
                        }
                    }


                    axios.post(`/api/category/${this.id}/update`, body, config)
                        .then((response) => {
                            this.isActive = false;

                            if (response.data.status == 200) {
                                swal2.fire({
                                    icon: 'success',
                                    title: 'Category updated successfuly',
                                    allowOutsideClick: false,
                                    showConfirmButton: true,
                                    confirmButtonText: 'Cancel'


                                }).then((result) => {
                                    if (result.value) {
                                        window.location = '/categories';
                                    }
                                })
                            }

                            if (response.data.status == 404) {
                                swal2.fire({
                                    icon: 'error',
                                    title: 'Category not found',
                                    allowOutsideClick: false,
                                    showConfirmButton: true,
                                    confirmButtonText: 'Cancel'


                                })
                            }


                            if (response.data.status == 405) {
                                swal2.fire({
                                    icon: 'error',
                                    title: 'Name already in use',
                                    allowOutsideClick: false,
                                    showConfirmButton: true,
                                    confirmButtonText: 'Cancel'


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
