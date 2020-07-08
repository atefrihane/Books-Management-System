<template>
    <div class="card card-primary">
        <h3 class=" p-4">Ajouter un utilisateur</h3>

        <form role="form">
            <div class="card-body">
                <show-errors :errors="errors"> </show-errors>
                <div class="row">
                    <div class="col-md-6">

                        <h5><strong>Informations personnelles</strong></h5>
                    </div>

                </div>

                <div class="row mt-2">
                    <div class="col-md-6">
                        <label for="exampleInputEmail1">Nom *</label>
                        <input type="text" class="form-control" placeholder="Nom.." v-model="user.last_name">
                    </div>
                    <div class="col-md-6">
                        <label for="exampleInputEmail1">Prénom *</label>
                        <input type="text" class="form-control" placeholder="Prénom.." v-model="user.first_name">
                    </div>

                </div>


                <div class="row mt-2">
                    <div class="col-md-6">
                        <label for="exampleInputEmail1" class="mt-2 mb-2">Occupation</label>
                        <select class="form-control" @change="selectOccupation($event)">
                            <option value="" selected disabled>Sélectionner une occupation</option>
                            <option value="1">Etudiant</option>
                            <option value="2">Autre</option>
                        </select>

                    </div>
                    <div class="col-md-6">
                        <label for="exampleInputEmail1" class="mt-2">Université/Instutition</label>
                        <input type="text" class="form-control" placeholder="Université/Instutition"
                            v-model="user.institution">

                    </div>

                </div>


                <div class="row mt-2">
                    <div class="col-md-6">
                        <label for="exampleInputEmail1" class="mt-2 mb-2">Numéro de téléphone</label>
                        <input type="text" class="form-control" placeholder="Numéro de téléphone..."
                            v-model="user.phone">
                    </div>


                </div>

                <div class="row mt-4">
                    <div class="col-md-6">

                        <h5><strong>Informations de connexion</strong></h5>
                    </div>

                </div>

                <div class="row mt-2">
                    <div class="col-md-6">
                        <label for="exampleInputEmail1" class="mt-2 mb-2">Email *</label>
                        <input type="email" class="form-control" placeholder="Email.." v-model="user.email">
                    </div>


                </div>

                <div class="row mt-2">
                    <div class="col-md-6">
                        <label for="exampleInputEmail1" class="mt-2 mb-2">Mot de passe *</label>
                        <input type="password" class="form-control" placeholder="Mot de passe.."
                            v-model="user.password">
                    </div>


                </div>


                <div class="row mt-2">
                    <div class="col-md-6">
                        <label for="exampleInputEmail1" class="mt-2 mb-2">Confirmation mot de passe *</label>
                        <input type="password" class="form-control" placeholder="Confirmation mot de passe.."
                            v-model="user.password_confirmation">
                    </div>


                </div>

                <div class="row mt-2">
                    <div class="col-md-6">
                        <label for="exampleInputEmail1" class="mt-2 mb-2">Type de compte *</label>
                        <select class="form-control" @change="selectRole($event)">
                            <option value="" selected disabled>Séléctionner un type de compte</option>
                            <option :value="role.id" v-for="role in roles">{{formatRole(role)}}</option>
                        </select>

                    </div>

                </div>

                <div class="row mt-2">
                    <div class="col-md-6">
                        <label for="exampleInputEmail1" class="mt-2 mb-2">Status du compte*</label>
                        <select class="form-control" @change="selectStatus($event)" :value="user.active">
                            <option value="0">Inactif</option>
                            <option value="1">Actif</option>
                        </select>

                    </div>

                </div>


                <div class="row mt-4">
                    <div class="col-md-6">

                        <h5><strong>Informations de livraison</strong></h5>
                    </div>

                </div>

                <div class="row mt-2">
                    <div class="col-md-6">
                        <label for="exampleInputEmail1" class="mt-2 mb-2">Pays</label>
                        <input type="text" class="form-control" placeholder="Pays..." v-model="user.country" disabled>
                    </div>

                </div>

                <div class="row mt-2">
                    <div class="col-md-6">
                        <label for="exampleInputEmail1" class="mt-2 mb-2">Ville</label>
                        <input type="text" class="form-control" placeholder="Ville..." v-model="user.city">
                    </div>

                    <div class="col-md-6">
                        <label for="exampleInputEmail1" class="mt-2 mb-2">Code de postal</label>
                        <input type="text" class="form-control" placeholder="Code de postal..." v-model="user.zipcode">
                    </div>

                </div>

                <div class="row mt-2">
                    <div class="col-md-6">
                        <label for="exampleInputEmail1" class="mt-2 mb-2">Addresse</label>
                        <input type="text" class="form-control" placeholder="Addresse..." v-model="user.address">
                    </div>

                </div>
                <div class="row mt-2">
                    <div class="col-md-6">
                        <label for="exampleInputEmail1" class="mt-2 mb-2">Nom du recipient</label>
                        <input type="text" class="form-control" placeholder="Nom du recipient..."
                            v-model="user.recipient">
                    </div>

                    <div class="col-md-6">
                        <label for="exampleInputEmail1" class="mt-2 mb-2">Téléphone du récipient</label>
                        <input type="text" class="form-control" placeholder="Téléphone du récipient..."
                            v-model="user.recipient_phone">
                    </div>

                </div>




                <div class="mx-auto mt-5" style="width: 200px;">
                    <div class="row">
                        <button class="btn btn-primary ml-3" @click.prevent="submitAddUser()" :disabled="this.disabled">
                            Confirmer</button>
                        <a href="/users" class="btn btn-danger ml-3">Annuler</a>



                    </div>
                </div>

            </div>
        </form>







    </div>
</template>

<script>
    import ShowErrors from './nested/ShowErrors.vue'
    export default {
        mounted() {
            console.log('Component mounted.')
        },
        props: ['roles'],
        data() {
            return {
                user: {
                    email: '',
                    password: '',
                    password_confirmation: '',
                    first_name: '',
                    last_name: '',
                    occupation: '',
                    institution: '',
                    country: 'Tunisie',
                    city: '',
                    zipcode: '',
                    phone: '',
                    recipient: '',
                    recipient_phone: '',
                    role_id: '',
                    icon: '',
                    active: 0
                },
                errors: [],
                disabled: false,
                emailReg: /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,24}))$/


            }
        },
        methods: {

            formatRole(role) {
                switch (role.name) {
                    case 'superadmin':
                        return this.$root.ucfirst(role.name)
                        break;

                    case 'admin':
                        return this.$root.ucfirst(role.name)

                        break;

                    case 'user':
                        return 'Internaute'

                        break;
                }
            },
            selectRole(event) {

                this.user.role_id = event.target.value
                // update type user
                this.roles.forEach(role => {
                    if (role.id == event.target.value) {
                        let roleName = role.name;
                        switch (roleName) {
                            case 'superadmin':
                                this.user.type = 1
                                break;

                            case 'admin':
                                this.user.type = 2

                                break;

                            case 'user':
                                this.user.type = 0

                                break;
                        }
                    }
                })
            },
            selectOccupation(event) {

                this.user.occupation = event.target.value

            },
            selectStatus(event) {

                this.user.active = event.target.value

            },
            validateEmail(email) {
                var re = /\S+@\S+\.\S+/;
                return re.test(email);
            },
            validateData() {
                this.errors = []
                if (!this.user.last_name) {

                    this.errors.push('Le nom est requis');
                    window.scrollTo(0, 0);
                    this.disabled = false;
                    return;
                }

                if (!this.user.first_name) {

                    this.errors.push('Le prenom est requis');
                    window.scrollTo(0, 0);
                    this.disabled = false;
                    return;
                }

                if (!this.user.email) {

                    this.errors.push('L\'email est requis');
                    window.scrollTo(0, 0);
                    this.disabled = false;
                    return;
                }

                if (!this.validateEmail(this.user.email)) {
                    this.errors.push('L\'email est invalide');
                    window.scrollTo(0, 0);
                    this.disabled = false;
                    return;
                }




                if (!this.user.password) {

                    this.errors.push('Le mot de passe est requis');
                    window.scrollTo(0, 0);
                    this.disabled = false;
                    return;
                }

                if (!this.user.password_confirmation) {

                    this.errors.push('La confirmation du  mot de passe est requise');
                    window.scrollTo(0, 0);
                    this.disabled = false;
                    return;
                }
                let comparePasswords = this.user.password.localeCompare(this.user.password_confirmation);
                if (comparePasswords < 0) {
                    this.errors.push('Les mots de passe ne se correpondent pas');
                    window.scrollTo(0, 0);
                    this.disabled = false;
                    return;

                }

                if (!this.user.role_id) {

                    this.errors.push('Veuillez séléctionner un type de compte');
                    window.scrollTo(0, 0);
                    this.disabled = false;
                    return;
                }

                return true;

            },

            submitAddUser() {
                this.disabled = true;
                let validate = this.validateData()
                if (validate) {
                    this.$Progress.start()
                    axios.post('/api/register/admin', {
                            user: this.user
                        })
                        .then((response) => {
                            this.$Progress.finish()
                            if (response.data.status == 200) {
                                swal2.fire({
                                    icon: 'success',
                                    title: 'Utilisateur ajouté avec succés',
                                    allowOutsideClick: false,
                                    showConfirmButton: true,
                                    confirmButtonText: 'Fermer'


                                }).then((result) => {
                                    if (result.value) {
                                        window.location = '/users';
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
