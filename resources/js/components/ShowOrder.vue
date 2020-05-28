<template>
    <div class="container-fluid">
        <div class="card card-primary">
            <h3 class=" p-4">Détail Achat &nbsp;<small>{{order.code}}</small>
            </h3>

            <form role="form">
                <div class="card-body">

                    <div class="row p-4">
                        <h5 class="font-weight-bold">
                            Informations générals</h5>
                    </div>

                    <div class="row mt-4">

                        <div class="col-md-6">
                            <label for="">Code</label>
                            <input type="text" class="form-control" :value="order.code" disabled></div>
                        <div class="col-md-6">
                            <label for="">Date et heure</label>
                            <input type="text" class="form-control" :value="order.created_at" disabled></div>

                    </div>

                    <div class="row mt-4">

                        <div class="col-md-6">
                            <label for="">Utilisateur</label>
                            <input type="text" class="form-control"
                                :value="$root.ucfirst(order.user.first_name)+' '+$root.ucfirst(order.user.last_name)"
                                disabled></div>
                        <div class="col-md-6">
                            <label for="">Montant (TND)</label>
                            <input type="text" class="form-control" :value="order.sumOrder.sum" disabled></div>

                    </div>

                    <div class="row p-4">
                        <h5 class="font-weight-bold">
                            Eléments achetés</h5>
                    </div>

                    <table class="table table-bordered table-hover  table-responsive-md mb-3 ">
                        <thead>
                            <tr>
                                <th scope="col">Photo</th>
                                <th scope="col">Titre</th>
                                <th scope="col">Type</th>
                                <th scope="col">Prix unitaire</th>
                                <th scope="col">Unités</th>
                                <th scope="col">Total</th>

                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="product in order.products">
                                <td style="width:5%;">

                                    <img :src="product.content.photo ? product.content.photo : '/img/placeholder.jpg' " alt="" class="img-fluid"></td>
                                <td>{{product.content.title}}</td>
                                <td>{{product.pivot.type == 1 ? 'Papier' : 'Digitale'}}</td>
                                <td>{{product.pivot.price}} TND</td>
                                <td>{{product.pivot.unit}}</td>
                                <td>{{product.pivot.total}} TND</td>
                            </tr>

                        </tbody>
                    </table>

                    <div class="row mt-4">
                        <div class="container mt-4">
                            <span class="float-left">
                                <h5>Total</h5>
                            </span>
                            <span class="float-right">
                                <h5>{{this.sumOrder}} TND</h5>
                            </span>

                        </div>

                    </div>

                    <div class="row">
                        <div class="container mt-4">
                            <span class="float-left">
                                <h5>Frais de la livraison</h5>
                            </span>
                            <span class="float-right">
                                <h5>{{this.fees}} TND</h5>
                            </span>

                        </div>

                    </div>

                    <div class="row">
                        <div class="container mt-4">
                            <span class="float-left">
                                <h5 class="font-weight-bold">Montant total à payer</h5>
                            </span>
                            <span class="float-right">
                                <h5>{{this.sumOrder}} TND</h5>
                            </span>

                        </div>

                    </div>


                    <div class="row p-4 mt-4">
                        <h5 class="font-weight-bold">
                            Détails de la livraison</h5>
                    </div>

                    <div class="row">

                        <div class="col-md-6">
                            <label for="">Etat</label>
                            <input type="text" class="form-control"
                                :value="order.status == 0 ? 'En attente' : order.status == 1 ? 'En cours'  : 'Livrée'"
                                disabled></div>


                    </div>


                    <div class="row mt-3">

                        <div class="col-md-6">
                            <label for="">Pays</label>
                            <input type="text" class="form-control" :value="$root.ucfirst(order.user.country)" disabled>
                        </div>


                    </div>


                    <div class="row mt-3">

                        <div class="col-md-6">
                            <label for="">Ville</label>
                            <input type="text" class="form-control"
                                :value="order.user.city ? $root.ucfirst(order.user.city) : 'Aucune'" disabled>
                        </div>

                        <div class="col-md-6">
                            <label for="">Code postal</label>
                            <input type="text" class="form-control"
                                :value="order.user.zipcode ? $root.ucfirst(order.user.zipcode) :'Aucun'" disabled>
                        </div>

                    </div>


                    <div class="row mt-3">

                        <div class="col-md-6">
                            <label for="">Nom du récipient</label>
                            <input type="text" class="form-control"
                                :value="order.user.recipient ? $root.ucfirst(order.user.recipient) : 'Aucun'" disabled>
                        </div>

                        <div class="col-md-6">
                            <label for="">Numéro téléphone du récipient</label>
                            <input type="text" class="form-control"
                                :value="order.user.recipient_phone ? order.user.recipient_phone :'Aucun'" disabled>
                        </div>

                    </div>


                    <div class="row mt-3">

                        <div class="col-md-12">
                            <label for="">Adresse</label>
                            <input type="text" class="form-control"
                                :value="order.user.address ? order.user.address : 'Aucune'" disabled>
                        </div>

                    </div>

                     <div class="row mt-3">

                        <div class="col-md-12">
                            <label for="">Notes pour la livraison</label>
                            <textarea class="form-control" cols="4" rows="4" disabled>{{order.comment ? order.comment :  'Aucune'}}
                         
                            </textarea>
                         
                        </div>

                    </div>
                    <div class="mx-auto mt-4" style="width: 200px;">
                        <div class="row">
                        <a href="/orders" class="btn btn-danger ml-3">Quitter</a>
                          

                        </div>
                    </div>

                </div>
            </form>

        </div>

    </div>
</template>

<script>
    export default {
        mounted() {


            this.totalOrder()

        },
        props: ['order'],
        data() {
            return {
                sumOrder: 0,
                fees: 0
            }
        },
        methods: {

            totalOrder() {

                this.order.products
                    .forEach(product => {
                        Vue.set(product.pivot, 'total', '')
                        product.pivot.total = product.pivot.unit * product.pivot.price
                        this.sumOrder += product.pivot.total + this.fees

                    })
            }
        }

    }

</script>
