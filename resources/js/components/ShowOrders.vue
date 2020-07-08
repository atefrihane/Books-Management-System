<template>
    <div>

        <div class="card">

            <div class="card-body">





                <table class="table table-bordered table-hover  table-responsive-sm">
                    <thead>
                        <tr>
                            <th scope="col">Code</th>
                            <th scope="col">Date et heure</th>
                            <th scope="col">Utilisateur</th>
                            <th scope="col">Unités</th>
                            <th scope="col">Montant total (TND)</th>
                            <th scope="col">Etat de la livraison</th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(order,index) in allOrders">

                            <td>{{order.code}}</td>
                            <td>{{order.created_at}}</td>
                            <td>{{($root.ucfirst(order.user.first_name)) + ' ' +($root.ucfirst(order.user.last_name)) }}
                            </td>
                            <td>{{order.products.length}}</td>
                            <td>{{order.sumOrder.sum}}</td>
                            <td>{{order.status == 0 ? 'En attente' : order.status == 1 ? 'En cours'  : order.status == 2 ? 'Livrée' : ''}}
                            </td>

                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-secondary dropdown-toggle btn-hide" type="button"
                                        id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                        aria-expanded="false">

                                        <i class="fas fa-ellipsis-h"></i>
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        <a class="dropdown-item" :href="`/order/${order.id}`">Voir
                                            détails</a>
                                        <a class="dropdown-item" :href="`/user/${order.user.id}`">Voir
                                            détails de l'utilisateur</a>
                                        <a class="dropdown-item" href="#" data-toggle="modal"
                                            data-target="#exampleModal" @click="affectOrder(order,index)">Modifier
                                            état</a>
                                    </div>
                                </div>
                            </td>

                        </tr>





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
    export default {
        mounted() {
            this.filterActiveorders();
            this.allOrders = this.orders

        },
        props: ['orders'],
        data() {
            return {
                allOrders: [],
                isChecked: false,
                orderId: '',
                orderIndex: '',
                newStatus: ''



            }

        },
        methods: {
            filterActiveorders() {

                this.allOrders = _.filter(this.allOrders, function (o) {
                    return o.active;
                });
            },
            filterordersClick() {
                this.$root.destroyDataTable()
                this.isChecked = !this.isChecked;

                // show all orders
                if (this.isChecked) {
                    this.allOrders = this.orders
                    this.$root.updateDataTable()

                    return;

                }
                //show only active

                this.filterActiveorders()
                this.$root.updateDataTable()
                return;

            },
            affectOrder(order, index) {
                this.orderId = order.id
                this.orderIndex = index
            },

            affectNewStatut(event) {
                this.newStatus = event.target.value

            },

            updateStatus() {
                axios.post(`api/order/${this.orderId}/status`, {
                        id: this.orderId,
                        status: this.newStatus
                    })
                    .then((response) => {
                        if (response.data.status == 200)

                        {
                    
                            this.allOrders[this.orderIndex].status=this.newStatus
                            toast.fire({
                                icon: 'success',
                                title: 'Etat modifié'
                            })

                        }

                        if (response.data.status == 404)

                        {
                            toast.fire({
                                icon: 'success',
                                title: 'Achat introuvable'
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
