<template>
    <div class="card card-primary">
        <h3 class=" p-4">Update user</h3>

        <form role="form">
            <div class="card-body">
                <show-errors :errors="errors"> </show-errors>


                <div class="row">
                    <div class="col-md-6">

                        <h5><strong>Access informations</strong></h5>
                    </div>

                </div>

                <div class="row mt-2">
                    <div class="col-md-6">
                        <label for="exampleInputEmail1" class="mt-2 mb-2">First Name </label>
                        <input type="text" class="form-control" :value="$root.ucfirst(first_name)" disabled>

                    </div>

                </div>

                <div class="row mt-2">
                    <div class="col-md-6">
                        <label for="exampleInputEmail1" class="mt-2 mb-2">Last Name </label>
                        <input type="text" class="form-control" :value="$root.ucfirst(last_name)" disabled>

                    </div>

                </div>


                       <div class="row mt-2">
                    <div class="col-md-6">
                        <label for="exampleInputEmail1" class="mt-2 mb-2">Email </label>
                        <input type="text" class="form-control" :value="$root.ucfirst(email)" disabled>

                    </div>

                </div>

                <div class="row mt-2">
                    <div class="col-md-6">
                        <label for="exampleInputEmail1" class="mt-2 mb-2">Account type *</label>
                        <select class="form-control" @change="selectRole($event)" :value="role_id">
                            <option value="" selected disabled>Select account type</option>
                            <option :value="role.id" v-for="role in roles">{{formatRole(role)}}</option>
                        </select>

                    </div>

                </div>




                <div class="row mt-2">
                    <div class="col-md-6">
                        <label for="exampleInputEmail1" class="mt-2 mb-2">Account status*</label>
                        <select class="form-control" @change="selectStatus($event)" :value="active">
                            <option value="0">Active</option>
                            <option value="1">Inactive</option>
                        </select>

                    </div>

                </div>







                <div class="mx-auto mt-5" style="width: 200px;">
                    <div class="row">
                        <button class="btn btn-primary ml-3" @click.prevent="submitUpdateUser()"
                            :disabled="this.disabled">
                            Confirm</button>
                        <a href="/users" class="btn btn-danger ml-3">Cancel</a>



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

                user_id: this.old_user.id,
                email: this.old_user.email,
                first_name: this.old_user.first_name,
                last_name: this.old_user.last_name,
                role_id: this.old_user.role_id,
                active: this.old_user.active,


                errors: [],
                disabled: false,
                emailReg: /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,24}))$/


            }
        },
        methods: {

            formatRole(role) {
             return this.$root.ucfirst(role.name)
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

            selectStatus(event) {

                this.active = event.target.value

            },
            validateEmail(email) {
                var re = /\S+@\S+\.\S+/;
                return re.test(email);
            },
            validateData() {
                this.errors = []





        

                if (!this.role_id) {

                    this.errors.push('Please select account type');
                    window.scrollTo(0, 0);
                    this.disabled = false;
                    return;
                }

                return true;

            },
            apiCall() {

                axios.post(`/api/admin/user/${this.user_id}/update`, {
                        user_id: this.user_id,
                        active: this.active,
                        role_id: this.role_id
                    })
                    .then((response) => {
                        this.$Progress.finish()
                        if (response.data.status == 200) {
                            swal2.fire({
                                type: 'success',
                                title: 'Used edited',
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


                    this.apiCall()




                }




            }
        }
    }

</script>
