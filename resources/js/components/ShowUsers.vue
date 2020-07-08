<template>
    <div>

        <div class="card">

            <div class="card-body">





                <table class="table table-bordered table-hover  table-responsive-sm">
                    <thead>
                        <tr>
                            <th scope="col">Full name</th>
                            <th scope="col">Email</th>
                            <th scope="col">Account type</th>
                            <th scope="col">Role</th>
                            <th scope="col">Last modification</th>
                            <th></th>

                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(user,index) in allUsers">


                            <td>{{$root.ucfirst(user.full_name)}}</td>
                            <td>{{user.email}} &nbsp;&nbsp; <i
                                    :class="[user.email_verified_at ? successMail : failedMail]" data-toggle="tooltip"
                                    data-placement="top" :title="statusEmail(user)"></i> </td>
                            <td>{{user.active == 0 ? 'Inactive' : user.active == 1  ? 'Active' : 'Blocked'}}</td>
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

                                        <a class="dropdown-item" :href="`/user/${user.id}`">Show
                                            details</a>
                                        <a class="dropdown-item" :href="`/user/${user.id}/update`"
                                          >Edit
                                            user</a>


                                        <a class="dropdown-item" data-toggle="modal" data-target="#exampleModal"
                                            @click="affectValue(user)" v-if="user.role.name != 'superadmin'">Delete</a>
                                    </div>
                                </div>
                            </td>

                        </tr>




                        <show-modal :element="this.user" v-on:removeItem="removeItem($event)" ref="modal"
                            v-if="this.user">
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


            statusEmail(user) {
                if (user.email_verified_at) {
                    return 'Email valid'
                }
                return 'Email not valid'
            },
        
            formatType(user) {
           
                return this.$root.ucfirst(user.role.name)

            },
       

            removeItem(event) {
               



                axios.post(`/api/user/${event.id}/delete`, {

                    })
                    .then((response) => {
                        if (response.data.status == 200) {

                            this.users.splice(this.users.indexOf(event), 1);
                            this.user = ''

                            toast.fire({
                                icon: 'success',
                                title: 'User deleted'
                            })
                            this.$root.destroyDataTable()
                            this.$root.updateDataTable()

                        }

                        if (response.data.status == 404) {
                            swal2.fire({
                                icon: 'error',
                                title: 'User  not found..',
                                allowOutsideClick: false,
                                showConfirmButton: true,
                                confirmButtonText: 'Fermer'


                            });
                        }
                    })


            },
            affectValue(user) {
                this.user = user

            }

        }

    }

</script>
