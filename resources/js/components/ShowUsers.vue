<template>
    <div>

        <div class="card">

            <div class="card-body">
                <div class="form-check">
                    <input class="form-check-input filterusers" type="checkbox" value="" id="defaultCheck1"
                        @click="filterUsersClick()">
                    <label class="form-check-label" for="defaultCheck1">
                        Afficher les élements desactivés
                    </label>
                </div>




                <table class="table table-bordered table-hover  table-responsive-sm">
                    <thead>
                        <tr>
                            <th scope="col">Nom et prénom</th>
                            <th scope="col">Email</th>
                            <th scope="col">Etat du compte</th>
                            <th scope="col">Type</th>
                            <th scope="col">Modifié le</th>
                            <th></th>

                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(user,index) in allUsers">


                            <td>{{formatName(user)}}</td>
                            <td>{{user.email}} &nbsp;&nbsp; <i
                                    :class="[user.email_verified_at ? successMail : failedMail]" data-toggle="tooltip"
                                    data-placement="top" :title="statusEmail(user)"></i> </td>
                            <td>{{user.active == 0 ? 'Inactif' : user.active == 1  ? 'Actif' : 'Bloqué'}}</td>
                            <td>{{formatType(user)}}</td>
                            <td>{{user.updated_at}}</td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-secondary dropdown-toggle btn-hide" type="button"
                                        id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                        aria-expanded="false">

                                        <i class="fas fa-ellipsis-h"></i>
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        <a class="dropdown-item" data-toggle="modal" data-target="#unblockUser"
                                            @click="affectUser(user,index)" v-if="user.active == 2">Débloquer</a>
                                        <a class="dropdown-item" :href="`/user/${user.id}`">Voir
                                            détails</a>

                                        <a class="dropdown-item" :href="`/user/${user.id}/update`">Modifier</a>
                                        <a class="dropdown-item" data-toggle="modal" data-target="#exampleModal"
                                            @click="affectValue(user)">Supprimer</a>
                                    </div>
                                </div>
                            </td>

                        </tr>




                        <show-modal :element="this.user" v-on:removeItem="removeItem($event)" ref="modal"
                            v-if="this.user">
                        </show-modal>

                    </tbody>
                </table>

        

                <!-- Modal Unblock Status -->
                <div class="modal fade" id="unblockUser" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">
                                    Voulez vous vraiment débloquer cet utilisateur ?
                                </h5>

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
            this.filterActiveUsers();

        },
        props: ['users'],
        data() {
            return {
                allUsers: this.users,
                isChecked: false,
                user: '',
                userId: '',
                userIndex: '',
                successMail: 'far fa-check-circle text-green',
                failedMail: 'fas fa-exclamation-triangle text-red'


            }

        },


        methods: {
            affectUser(user, index) {
                this.userId = user.id
                this.userIndex = index
            },
            updateStatus() {

                axios.get(`/api/user/${this.userId}/unblock`)
                    .then((response) => {

                        if (response.data.status == 200)

                        {

                            this.allUsers[this.userIndex].active = 1
                            toast.fire({
                                type: 'success',
                                title: 'Utilisateur débloqué'
                            })

                        }

                        if (response.data.status == 404)

                        {
                            toast.fire({
                                type: 'success',
                                title: 'Utilisateur introuvable'
                            })

                        }
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
            },

            statusEmail(user) {
                if (user.email_verified_at) {
                    return 'Email validé'
                }
                return 'Email non validé'
            },
            formatName(user) {
                return user.first_name + ' ' + user.last_name

            },
            formatType(user) {
                if (user.role.name == 'user') {
                    return 'Internaute';
                }

                return this.$root.ucfirst(user.role.name)

            },
            filterActiveUsers() {


                this.allUsers = _.filter(this.allUsers, function (o) {
                    return o.active;
                });



            },
            filterUsersClick() {
                this.$root.destroyDataTable()
                this.isChecked = !this.isChecked;

                // show all users
                if (this.isChecked) {
                    this.allUsers = this.users
                    this.$root.updateDataTable()

                    return;

                }
                //show only active

                this.filterActiveUsers()
                this.$root.updateDataTable()
                return;

            },

            removeItem(event) {
                let userstatus = event.active;



                axios.post(`/api/user/${event.id}/delete`, {

                    })
                    .then((response) => {
                        if (response.data.status == 200) {

                            this.users.splice(this.users.indexOf(event), 1);
                            this.allUsers = this.users
                            toast.fire({
                                type: 'success',
                                title: 'Utilisateur supprimée'
                            })

                            this.isChecked = !this.isChecked
                            this.filterUsersClick()
                        }

                        if (response.data.status == 404) {
                            swal2.fire({
                                type: 'error',
                                title: 'Utilisateur  introuvable..',
                                allowOutsideClick: false,
                                showConfirmButton: true,
                                confirmButtonText: 'Fermer'


                            });
                        }
                    })


            },
            affectValue(user) {
                this.user = user
                let element = this.$refs.modal
                $(element).modal('show')
            }

        }

    }

</script>
