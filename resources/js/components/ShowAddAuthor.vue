<template>
    <div class="container-fluid">
        <div class="card card-primary">
            <h3 class=" p-4">Ajouter un auteur</h3>

            <form role="form">
                <div class="card-body">
                    <show-errors :errors="errors"> </show-errors>
                    <div class="row">
                        <div class="col-md-12">
                            <img :src="author.photo" class="rounded mx-auto d-block mb-3 img-upload" style="height:20vh;"
                                @click="$refs.file.click()">
                            <input type="file" ref="file" style="display: none" @change="uploadFile($event,0)">

                        </div>

                    </div>

               
                    <div class="row">
                        <div class="col-md-12">
                            <label for="exampleInputEmail1">Nom</label>
                            <input type="text" class="form-control" placeholder="Nom.." v-model="author.last_name">
                        </div>

                    </div>


                 <div class="row mt-3">
                        <div class="col-md-12">
                            <label for="exampleInputEmail1">Prénom</label>
                            <input type="text" class="form-control" placeholder="Prénom.." v-model="author.first_name">
                        </div>

                    </div>



                    <div class="row mt-3">
                        <div class="col-md-12">
                            <label for="exampleInputEmail1">Déscription</label>
                            <textarea class="form-control" rows="3" placeholder="Déscription.."
                                v-model="author.biography"></textarea>
                        </div>

                    </div>
               


         
                    <div class="mx-auto mt-4" style="width: 200px;">
                        <div class="row">
                            <button type="button" class="btn btn-danger ml-3">Annuler</button>
                            <button type="button" class="btn btn-primary ml-4" @click="submitAddAuthor()"
                                :disabled="disabled">Confirmer</button>
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
   
        data() {
            return {
            
                errors: [],
                disabled:false,
                author: {
                    first_name:'',
                    last_name:'',
                    biography:'',
                    photo: '/img/placeholder.jpg',
                
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
                        this.author.photo = file.link

                        return;
                    } else {
                        this.author.digital_link = file.link
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
          
            validateData() {
                this.errors = []
                if (this.author.photo == '/img/placeholder.jpg') {
                    this.disabled = false;
                    this.errors.push('Veuillez importer une photo pour l\'auteur');
                    window.scrollTo(0, 0);
                    return;
                }
                if (!this.author.last_name) {
                    this.disabled = false;
                    this.errors.push('Le Nom est requis');
                    window.scrollTo(0, 0);
                    return;
                }

                    if (!this.author.first_name) {
                    this.disabled = false;
                    this.errors.push('Le Prénom est requis');
                    window.scrollTo(0, 0);
                    return;
                }
            
                  if (!this.author.biography) {
                    this.disabled = false;
                    this.errors.push('La biographie est requise');
                    window.scrollTo(0, 0);
                    return;
                }
            
            

             

                return true;



            },
            submitAddAuthor() {
                this.disabled = true;
                let validate = this.validateData()
                if (validate) {
                      this.$Progress.start()
                    axios.post('/api/author/add', {
                            author: this.author
                        })
                        .then((response) => {
                              this.$Progress.finish()
                            if (response.data.status == 200) {
                                swal2.fire({
                                    type: 'success',
                                    title: 'Auteur ajouté avec succés',
                                    allowOutsideClick: false,
                                    showConfirmButton: true,
                                    confirmButtonText: 'Fermer'


                                }).then((result) => {
                                    if (result.value) {
                                        window.location = '/authors';
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




            }


        }

    }

</script>
