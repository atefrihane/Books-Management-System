<template>
    <div>

        <div class="card">

            <div class="card-body">





                <table class="table table-bordered table-hover  table-responsive-sm">
                    <thead>
                        <tr>
                            <th scope="col">Photo</th>
                            <th scope="col">Title</th>
                            <th scope="col">Categories</th>

                            <th scope="col">Status</th>
                            <th scope="col">Last edit</th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="book in allBooks">

                            <td class="style-image">
                                <div class="container">
                                    <img :src="book.photo ? book.photo : '/img/placeholder.jpg'" alt=""
                                        class="img-fluid">
                                </div>


                            </td>
                            <td>{{book.title}}</td>
                            <td>{{book.categories_count}}</td>


                            <td>{{book.active == 1 ? 'Active' : 'Inactive'}}</td>
                            <td>{{book.updated_at}}</td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-secondary dropdown-toggle btn-hide" type="button"
                                        id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                        aria-expanded="false">

                                        <i class="fas fa-ellipsis-h"></i>
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        <a class="dropdown-item" :href="`/book/${book.id}`">Show
                                            details</a>
                                        <a class="dropdown-item" :href="`/book/${book.id}/update`">Edit</a>
                                        <a class="dropdown-item" href="#" data-toggle="modal"
                                            data-target="#exampleModal" @click="affectValue(book)">Delete</a>
                                    </div>
                                </div>
                            </td>

                        </tr>

                        <show-modal :element="this.book" v-on:removeItem="removeItem($event)" ref="modal"
                            v-if="this.book">
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
        props: ['books'],
        data() {
            return {
                allBooks: this.books,
                isChecked: false,
                book: ''


            }

        },
        methods: {


            removeItem(event) {
                let bookStatus = event.active;

                axios.post(`/api/book/${event.id}/delete`, {

                    })
                    .then((response) => {
                        if (response.data.status == 200) {

                            this.books.splice(this.books.indexOf(event), 1);
                            this.allBooks = this.books;
                            toast.fire({
                                icon: 'success',
                                title: 'Book deleted'
                            })

                            this.book = ''
                            this.$root.destroyDataTable()
                            this.$root.updateDataTable()
                        }

                        if (response.data.status == 404) {
                            swal2.fire({
                                icon: 'error',
                                title: 'Book not found..',
                                allowOutsideClick: false,
                                showConfirmButton: true,
                                confirmButtonText: 'Fermer'


                            });
                        }
                    })


            },
            affectValue(book) {
                this.book = book

            }

        }

    }

</script>
