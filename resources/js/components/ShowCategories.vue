<template>
    <div>

        <div class="card">

            <div class="card-body">





                <table class="table table-bordered table-hover  table-responsive-sm">
                    <thead>
                        <tr>
                            <th scope="col">Name</th>
                            <th scope="col">Last modification</th>
                            <th></th>

                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(category,index) in this.allCategories">


                            <td>{{$root.ucfirst(category.name)}}</td>

                            <td>{{category.updated_at}}</td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-secondary dropdown-toggle btn-hide" type="button"
                                        id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                        aria-expanded="false">

                                        <i class="fas fa-ellipsis-h"></i>
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">

                                        <a class="dropdown-item" :href="`/category/${category.id}`">Show
                                            details</a>
                                        <a class="dropdown-item" :href="`/category/${category.id}/update`">Edit
                                        </a>


                                        <a class="dropdown-item" data-toggle="modal" data-target="#exampleModal"
                                            @click="affectValue(category)">Delete</a>
                                    </div>
                                </div>
                            </td>

                        </tr>




                        <show-modal :element="this.category" v-on:removeItem="removeItem($event)" ref="modal"
                            v-if="this.category">
                        </show-modal>

                    </tbody>
                </table>





            </div><!-- /.card-body -->


        </div>

    </div>

</template>

<script>
    import ShowModal from './nested/ShowModal.vue'
    export default {
        mounted() {
            this.allCategories = this.categories

        },
        props: ['categories'],
        data() {
            return {

                isChecked: false,
                category: '',
                categoryId: '',
                categoryIndex: '',
                successMail: 'far fa-check-circle text-green',
                failedMail: 'fas fa-exclamation-triangle text-red',
                allCategories: []


            }

        },


        methods: {




            removeItem(event) {

           

                axios.post(`/api/category/${event.id}/delete`, {

                    })
                    .then((response) => {
                        if (response.data.status == 200) {
                         console.log(event) 
                            this.allCategories.splice(this.allCategories.indexOf(event), 1);
                            this.category  =''
                            toast.fire({
                                icon: 'success',
                                title: 'Category deleted'
                            })

                               this.$root.destroyDataTable()
                                this.$root.updateDataTable()
                         


                        }

                        if (response.data.status == 400) {
                            swal2.fire({
                                icon: 'error',
                                title: 'Category not found..',
                                allowOutsideClick: false,
                                showConfirmButton: true,
                                confirmButtonText: 'Cancel'


                            });
                            this.disabled = false
                        }
                    })


            },
            affectValue(category) {
             
                this.category = category
     
            }

        }

    }

</script>
