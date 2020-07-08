<template>
    <div>

        <div class="card">

            <div class="card-body">


                <table class="table table-breviewsed table-hover  table-responsive-sm">
                    <thead>
                        <tr>
                            <th scope="col">Utilisateur</th>
                            <th scope="col">Titre</th>
                            <th scope="col">Evaluation</th>
                            <th scope="col">Commentaire</th>
                            <th scope="col">Modifié le </th>
                            <th scope="col">Etat</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(review,index) in allReviews">
                            <td>{{($root.ucfirst(review.user.first_name)) + ' ' +($root.ucfirst(review.user.last_name)) }}
                            </td>
                            <td>{{$root.ucfirst(review.product.content.title)}}</td>
                            <td>{{review.rating}} /5</td>


                            <td>{{review.comment ? review.comment : 'Aucun'}}</td>
                            <td>{{review.updated_at}}</td>
                            <td>{{review.active == 0 ? 'En attente' :  review.active == 1 ?   'Visible' : 'Bloqué'  }}
                            </td>

                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-secondary dropdown-toggle btn-hide" type="button"
                                        id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                        aria-expanded="false">

                                        <i class="fas fa-ellipsis-h"></i>
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#showReview"
                                            @click="affectUser(review,index)"> Voir
                                            détails</a>
                                        <a class="dropdown-item" :href="`/user/${review.user.id}`">Voir
                                            détails de l'utilisateur</a>

                                        <a class="dropdown-item" data-toggle="modal" data-target="#blockUser"
                                            @click="affectUser(review,index)" v-if="review.user.active == 1">
                                            Bloquer l'utilisateur</a>

                                        <a class="dropdown-item" data-toggle="modal" data-target="#unblockUser"
                                            @click="affectUser(review,index)" v-if="review.user.active == 2">
                                            Déloquer l'utilisateur</a>
                                        <a class="dropdown-item" href="#" data-toggle="modal"
                                            data-target="#exampleModal" @click="affectReview(review,index)">Modifier
                                            état</a>
                                    </div>
                                </div>
                            </td>

                        </tr>





                    </tbody>
                </table>


                <!-- Modal Block   User -->
                <div class="modal fade" id="blockUser" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">
                                    Voulez vous vraiment bloquer cet utilisateur ?
                                </h5>

                            </div>


                            <div class="modal-footer">
                                <a href="#" data-dismiss="modal" class="btn btn-danger">Annuler</a>
                                <a href="#" data-dismiss="modal" class="btn btn-primary"
                                    @click="blockUser()">Confirmer</a>

                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal unBlock   User -->
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
                                    @click="unblockUser()">Confirmer</a>

                            </div>
                        </div>
                    </div>
                </div>
                <!-- Modal Change Status -->
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
                                    <option :value="0">En attente</option>
                                    <option :value="1">Visible</option>
                                    <option :value="2">Bloqué</option>
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

                <!-- Modal Show Review -->
                <div class="modal fade" id="showReview" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                    aria-hidden="true" v-if="this.review">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">
                                    {{($root.ucfirst(this.review.user.first_name)) + ' ' +($root.ucfirst(this.review.user.last_name)) }}
                                </h5>

                            </div>
                            <div class="modal-body">
                                <label for="">Commentaire</label>
                                <textarea rows="10" class="form-control">{{this.review.comment}}</textarea>
                            </div>

                            <div class="modal-footer">
                                <a href="#" data-dismiss="modal" class="btn btn-danger">Quitter</a>


                            </div>
                        </div>
                    </div>
                </div>

            </div><!-- /.card-body -->


        </div>

    </div>

</template>

<script>
    export default {
        mounted() {

            this.allReviews = this.reviews

        },
        props: ['reviews'],
        data() {
            return {
                allReviews: [],
                isChecked: false,
                reviewId: '',
                reviewIndex: '',
                userId: '',
                userIndex: '',
                newStatus: '',
                review: ''



            }

        },
        methods: {


            affectReview(review, index) {
                this.reviewId = review.id
                this.reviewIndex = index
            },
            affectUser(review, index) {
                this.userId = review.user.id
                this.userIndex = index
                this.review = review
            },

            affectNewStatut(event) {
                this.newStatus = event.target.value

            },

            updateStatus() {
                axios.post(`/api/review/${this.reviewId}/status`, {
                        id: this.reviewId,
                        status: this.newStatus
                    })
                    .then((response) => {
                        if (response.data.status == 200)

                        {

                            this.allReviews[this.reviewIndex].active = this.newStatus
                            toast.fire({
                                icon: 'success',
                                title: 'Etat modifié'
                            })

                        }

                        if (response.data.status == 404)

                        {
                            toast.fire({
                                icon: 'error',
                                title: 'Erreur'
                            })

                        }
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
            },
            blockUser() {
                axios.get(`/api/user/${this.userId}/block/`)
                    .then((response) => {
                        console.log(response)
                        if (response.data.status == 200)

                        {

                            toast.fire({
                                icon: 'success',
                                title: 'Utilisateur bloqué'
                            })
                            this.allReviews.forEach(review => {
                                if (review.user.id == this.userId) {
                                    review.user.active = 2
                                }
                            });
                            this.userId = ''
                            this.userIndex = ''
                            this.review = ''

                        }

                        if (response.data.status == 404)

                        {
                            toast.fire({
                                icon: 'error',
                                title: 'Erreur'
                            })

                        }
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
            },
            unblockUser() {
                axios.get(`/api/user/${this.userId}/unblock/`)
                    .then((response) => {
                        if (response.data.status == 200)

                        {

                            toast.fire({
                                icon: 'success',
                                title: 'Utilisateur débloqué'
                            })
                            this.allReviews.forEach(review => {
                                if (review.user.id == this.userId) {
                                    review.user.active = 1
                                }
                            });

                            this.userId = ''
                            this.userIndex = ''
                            this.review = ''

                        }

                        if (response.data.status == 404)

                        {
                            toast.fire({
                                icon: 'error',
                                title: 'Erreur'
                            })

                        }
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
            }



        }

    }

</script>
