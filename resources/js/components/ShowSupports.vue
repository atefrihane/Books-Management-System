<template>
    <div>

        <div class="card">

            <div class="card-body">





                <table class="table table-borderd table-hover  table-responsive-sm">
                    <thead>
                        <tr>

                            <th scope="col">Utilisateur</th>
                            <th scope="col">Sujet</th>
                            <th scope="col">Reçu le</th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(support,index) in allSupports">

                            <td>{{$root.ucfirst(support.user.first_name)+' '+$root.ucfirst(support.user.last_name)}}
                            </td>
                            <td>{{$root.ucfirst(support.reason)}}</td>
                            <td>{{support.created_at}}</td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-secondary dropdown-toggle btn-hide" type="button"
                                        id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                        aria-expanded="false">

                                        <i class="fas fa-ellipsis-h"></i>
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        <a class="dropdown-item" :href="`/support/${support.id}`">
                                           Répondre</a>
                                        <a class="dropdown-item" :href="`/user/${support.user.id}`">Voir
                                            détails de l'utilisateur</a>
                                        <a class="dropdown-item" @click="affectValue(support)" data-toggle="modal"
                                            data-target="#exampleModal">Supprimer</a>
                                    </div>
                                </div>
                            </td>

                        </tr>



                        <show-modal :element="this.support" v-on:removeItem="removeItem($event)" ref="modal"
                            v-if="this.support">
                        </show-modal>

                    </tbody>
                </table>


                <!-- Modal -->
                <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog"
                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">
                                    Changement de l'etat
                                </h5>

                            </div>
                            <div class="modal-body">
                                <label for="">Nouveau état</label>
                                <select class="form-control" @change="affectNewStatut($event)">
                                    <option value="0" selected>En attente</option>
                                    <option value="1">En cours</option>
                                    <option value="2">Livrée</option>
                                </select>
                            </div>

                            <div class="modal-footer">
                                <a href="#" data-dismiss="modal" class="btn btn-danger">Annuler</a>
                                <a href="#" data-dismiss="modal" class="btn btn-primary"
                                    @click="updateStatus()">Confirmer</a>

                            </div>
                        </div>
                    </div>
                </div>

            </div><!-- /.card-body -->


        </div>

    </div>

</template>

<script>
    import ShowModal from './nested/ShowModal.vue'
    export default {
        mounted() {

            this.allSupports = this.supports


        },
        props: ['supports'],
        data() {
            return {
                allSupports: [],
                isChecked: false,
                supportId: '',
                supportIndex: '',
                newStatus: '',
                support: ''



            }

        },
        methods: {


            affectSupport(support, index) {
                this.supportId = support.id
                this.supportIndex = index
            },



            affectValue(support) {
                this.support = support
                let element = this.$refs.modal
                $(element).modal('show')
            },
            removeItem(event) {
                let supportStatus = event.active;
                console.log(event);
                axios.post(`/api/supports/${event.id}/delete`, {

                    })
                    .then((response) => {
                        if (response.data.status == 200) {

                            this.supports.splice(this.supports.indexOf(event), 1);
                            this.allsupports = this.supports;
                            toast.fire({
                                type: 'success',
                                title: 'Avis supprimé'
                            })

                            this.isChecked = !this.isChecked

                        }

                        if (response.data.status == 404) {
                            swal2.fire({
                                type: 'error',
                                title: 'Avis introuvable..',
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
