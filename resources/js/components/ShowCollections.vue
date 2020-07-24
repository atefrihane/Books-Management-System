<template>
    <div>

        <div class="card">

            <div class="card-body">

                <table class="table table-bordered table-hover  table-responsive-sm">
                    <thead>
                        <tr>
                            <th scope="col">Photo</th>
                            <th scope="col">Name</th>
                            <th scope="col">Books</th>
                            <th scope="col">Last modification</th>
                            <th></th>

                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="collection in allCollections">

                            <td class="style-image">
                                <div class="container">
                                    <img :src="collection.photo ? collection.photo : '/img/placeholder.jpg'" alt=""
                                        class="img-fluid">
                                </div>


                            </td>
                            <td>{{$root.ucfirst(collection.name)}}</td>
                            <td>{{collection.books_count}}</td>
                            <td>{{collection.updated_at}}</td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-secondary dropdown-toggle btn-hide" type="button"
                                        id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                        aria-expanded="false">

                                        <i class="fas fa-ellipsis-h"></i>
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">

                                        <a class="dropdown-item" :href="`/collection/${collection.id}`">Show
                                            details</a>
                                        <a class="dropdown-item" :href="`/collection/${collection.id}/update`">Edit
                                            collection</a>


                                        <a class="dropdown-item" data-toggle="modal" data-target="#exampleModal"
                                            @click="affectValue(collection)">Delete</a>
                                    </div>
                                </div>
                            </td>

                        </tr>




                        <show-modal :element="this.collection" v-on:removeItem="removeItem($event)" ref="modal"
                            v-if="this.collection">
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


        },
        props: ['collections'],
        data() {
            return {
                allCollections: this.collections,
                isChecked: false,
                collection: '',
                collectionId: '',
                collectionIndex: '',
                successMail: 'far fa-check-circle text-green',
                failedMail: 'fas fa-exclamation-triangle text-red'


            }

        },


        methods: {
            affectCollection(collection, index) {
                this.collectionId = collection.id
                this.collectionIndex = index
            },


            statusEmail(collection) {
                if (collection.email_verified_at) {
                    return 'Email valid'
                }
                return 'Email not valid'
            },

            formatType(collection) {

                return this.$root.ucfirst(collection.role.name)

            },


            removeItem(event) {




                axios.post(`/api/collection/${event.id}/delete`, {

                    })
                    .then((response) => {
                        if (response.data.status == 200) {

                            this.collections.splice(this.collections.indexOf(event), 1);
                            this.collection = ''

                            toast.fire({
                                icon: 'success',
                                title: 'collection deleted'
                            })
                            this.$root.destroyDataTable()
                            this.$root.updateDataTable()

                        }

                        if (response.data.status == 404) {
                            swal2.fire({
                                icon: 'error',
                                title: 'collection  not found..',
                                allowOutsideClick: false,
                                showConfirmButton: true,
                                confirmButtonText: 'Fermer'


                            });
                        }
                    })


            },
            affectValue(collection) {
                this.collection = collection

            }

        }

    }

</script>
