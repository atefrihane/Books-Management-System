<template>
    <div class="card card-primary">
        <h3 class=" p-4">Update user</h3>

        <form role="form">
            <div class="card-body">
                <show-errors :errors="errors"> </show-errors>
                <div class="row">
                    <div class="col-md-6">
                        <h5><strong>Personal informations</strong></h5>
                    </div>

                </div>

                <div class="row mt-2">
                    <div class="col-md-6">
                        <label for="exampleInputEmail1">Last name *</label>
                        <input type="text" class="form-control" placeholder="Nom.." v-model="user.last_name">
                    </div>
                    <div class="col-md-6">
                        <label for="exampleInputEmail1">First name *</label>
                        <input type="text" class="form-control" placeholder="Prénom.." v-model="user.first_name">
                    </div>

                </div>







                <div class="row mt-4">
                    <div class="col-md-6">

                        <h5><strong>Access informations</strong></h5>
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
                        <label for="exampleInputEmail1" class="mt-2 mb-2">Account type *</label>
                        <select class="form-control" @change="selectRole($event)" :value="user.role_id">
                            <option value="" selected disabled>Select account type</option>
                            <option :value="role.id" v-for="role in roles">{{formatRole(role)}}</option>
                        </select>

                    </div>

                </div>




                <div class="row mt-2">
                    <div class="col-md-6">
                        <label for="exampleInputEmail1" class="mt-2 mb-2">Account status*</label>
                        <select class="form-control" @change="selectStatus($event)" :value="user.active">
                            <option value="0">Active</option>
                            <option value="1">Inactive</option>
                        </select>

                    </div>

                </div>


          

                <div class="row mt-2">
                    <div class="col-md-6">
                        <label for="exampleInputEmail1" class="mt-2 mb-2">Country</label>
                        <input type="text" class="form-control" placeholder="Pays..."
                            :value="$root.ucfirst(user.country)" disabled>
                    </div>

                </div>




                <div class="mx-auto mt-5" style="width: 200px;">
                    <div class="row">
                        <button class="btn btn-primary ml-3" @click.prevent="submitUpdateUser()"
                            :disabled="this.disabled">
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


        },
        props: ['roles', 'old_user'],
        data() {
            return {
                user: {
                    user_id: this.old_user.id,
                    email: this.old_user.email,
                    first_name: this.old_user.first_name,
                    last_name: this.old_user.last_name,
                    occupation: this.old_user.occupation,
                    institution: this.old_user.institution,
                    country: this.old_user.country,
                    city: this.old_user.city,
                    zipcode: this.old_user.zipcode,
                    phone: this.old_user.phone,
                    recipient: this.old_user.recipient,
                    recipient_phone: this.old_user.recipient_phone,
                    role_id: this.old_user.role_id,
                    type: this.old_user.type,
                    active: this.old_user.active,
                    email_verified_at: this.old_user.email_verified_at

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

                if (!this.user.email_verified_at) {
                    swal2.fire({
                        type: 'error',
                        title: 'Cet utilisateur n\'pas encore verifié son email',
                        allowOutsideClick: false,
                        showConfirmButton: true,
                        confirmButtonText: 'Fermer'


                    })
                    this.disabled = false;
                    return;
                }
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


                if (!this.user.role_id) {

                    this.errors.push('Veuillez séléctionner un type de compte');
                    window.scrollTo(0, 0);
                    this.disabled = false;
                    return;
                }

                return true;

            },
            apiCall() {

                let users = _.omit(this.user, ['password']);
                axios.post(`/api/admin/user/${this.user.user_id}/update`, {
                        user: users
                    })
                    .then((response) => {
                        this.$Progress.finish()
                        if (response.data.status == 200) {
                            swal2.fire({
                                type: 'success',
                                title: 'Utilisateur modifié avec succés',
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

            },

            submitUpdateUser() {
                this.disabled = true;
                let validate = this.validateData()
                if (validate) {
                    this.$Progress.start()

                    if (this.user.active == 0) {
                        this.disabled = false;
                        swal2.fire({
                            title: 'Attention',
                            text: "Voulez vous vraiment désactiver cet utilisateur ?",
                            type: 'info',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Confirmer',
                            cancelButtonText: 'Annuler'
                        }).then((result) => {
                            if (result.value) {
                                this.apiCall();
                            }
                        })

                    } else {

                        this.apiCall()
                    }




                }




            }
        }
    }

</script>
