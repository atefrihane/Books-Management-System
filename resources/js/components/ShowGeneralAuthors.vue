<template>
    <div>

        <div class="card">

            <div class="card-body">


           <table class="table table-bordered table-hover  table-responsive-sm">
                    <thead>
                        <tr>
                            <th scope="col">Photo</th>
                            <th scope="col">Full name</th>
                             <th scope="col " class="is-wrapped">Biography</th>
                          
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="author in allAuthors">

                            <td class="style-image">
                                <div class="container">
                                    <img :src="author.photo ? author.photo : '/img/placeholder.jpg'" alt="" class="img-fluid">
                                </div>


                            </td>
                            <td>{{$root.ucfirst(author.first_name)+' '+$root.ucfirst(author.last_name)}}</td>
                          <td>{{author.biography}}</td>
                          
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-secondary dropdown-toggle btn-hide" type="button"
                                        id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                        aria-expanded="false">

                                        <i class="fas fa-ellipsis-h"></i>
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        <a class="dropdown-item" :href="`/author/${author.id}`">Show
                                            details</a>
                                        <a class="dropdown-item" :href="`/author/${author.id}/update`">Edit</a>
                                        <a class="dropdown-item" href="#" data-toggle="modal"
                                            data-target="#exampleModal" @click="affectValue(author)">Delete</a>
                                    </div>
                                </div>
                            </td>

                        </tr>

                        <show-modal :element="this.author" v-on:removeItem="removeItem($event)" ref="modal"
                            v-if="this.author">
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

            this.allAuthors = this.authors

        },
        props: ['authors'],
        data() {
            return {
                allAuthors: [],
                isChecked: false,
                authorId: '',
                authorIndex: '',
                userId: '',
                userIndex: '',
                newStatus: '',
                author : ''



            }

        },
        methods: {


                affectValue(author) {
                this.author = author
        
            },
          

            affectNewStatut(event) {
                this.newStatus = event.target.value

            },

            updateStatus() {
                axios.post(`api/author/${this.authorId}/status`, {
                        id: this.authorId,
                        status: this.newStatus
                    })
                    .then((response) => {
                        if (response.data.status == 200)

                        {

                            this.allAuthors[this.authorIndex].active = this.newStatus
                            toast.fire({
                                type: 'success',
                                title: 'Etat modifié'
                            })

                        }

                        if (response.data.status == 404)

                        {
                            toast.fire({
                                type: 'success',
                                title: 'Achat introuvable'
                            })

                        }
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
            },
              removeItem(event) {
                let authorStatus = event.active;

                axios.post(`/api/author/${event.id}/delete`, {

                    })
                    .then((response) => {
                        if (response.data.status == 200) {
        
                            this.authors.splice(this.authors.indexOf(event), 1);
                            this.allAuthors = this.authors;
                            toast.fire({
                                type: 'success',
                                title: 'Auteur deleted'
                            })

                             this.author = ''
                            this.$root.destroyDataTable()
                            this.$root.updateDataTable()
                        
                        }

                        if (response.data.status == 404) {
                            swal2.fire({
                                type: 'error',
                                title: 'Author not found..',
                                allowOutsideClick: false,
                                showConfirmButton: true,
                                confirmButtonText: 'Fermer'


                            });
                        }
                    })


            },



        }

    }

</script>
