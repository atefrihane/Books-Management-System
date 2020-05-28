<template>
    <div>

        <div class="card">

            <div class="card-body">
                <div class="form-check">
                    <input class="form-check-input filterreleases" type="checkbox" value="" id="defaultCheck1"
                        @click="filterReleasesClick()">
                    <label class="form-check-label" for="defaultCheck1">
                        Afficher les élements desactivés
                    </label>
                </div>




                <table class="table table-bordered table-hover  table-responsive-sm">
                    <thead>
                        <tr>
                            <th scope="col">Photo</th>
                            <th scope="col">Titre</th>
                            <th scope="col">Domaine(s)</th>
                            <th scope="col">Auteur(s)</th>
                            <th scope="col">Année</th>
                            <th scope="col">Etat</th>
                            <th scope="col">Dérniere modification</th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="release in allReleases">

                            <td class="style-image">
                                <div class="container">
                                    <img :src="release.photo ? release.photo : '/img/placeholder.jpg'" alt="" class="img-fluid">
                                </div>


                            </td>
                            <td>{{release.title}}</td>
                            <td>{{release.categories.length}}</td>
                            <td>{{release.authors.length}}</td>
                            <td>{{release.published_year}}</td>
                            <td>{{release.active == 1 ? 'Actif' : 'Inactif'}}</td>
                            <td>{{release.updated_at}}</td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-secondary dropdown-toggle btn-hide" type="button"
                                        id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                        aria-expanded="false">

                                        <i class="fas fa-ellipsis-h"></i>
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        <a class="dropdown-item" :href="`/release/${release.id}`">Voir
                                            détails</a>
                                        <a class="dropdown-item" :href="`/release/${release.id}/update`">Modifier</a>
                                        <a class="dropdown-item" href="#" data-toggle="modal"
                                            data-target="#exampleModal" @click="affectValue(release)">Supprimer</a>
                                    </div>
                                </div>
                            </td>

                        </tr>

                        <show-modal :element="this.release" v-on:removeItem="removeItem($event)" ref="modal"
                            v-if="this.release">
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
            this.filterActiveReleases();

        },
        props: ['journal'],
        data() {
            return {
                allReleases: this.journal.releases,
                isChecked: false,
                release: ''


            }

        },
        methods: {
            filterActiveReleases() {
        
                this.allReleases = _.filter(this.allReleases, function (o) {
                    return o.active;
                });
            },
            filterReleasesClick() {
                this.$root.destroyDataTable()
                this.isChecked = !this.isChecked;

                // show all releases
                if (this.isChecked) {
                    this.allReleases = this.journal.releases
                    this.$root.updateDataTable()

                    return;

                }
                //show only active

                this.filterActiveReleases()
                this.$root.updateDataTable()
                return;

            },

            removeItem(event) {
                let releaseStatus = event.active;

                axios.post(`/api/release/${event.id}/delete`, {

                    })
                    .then((response) => {
                        if (response.data.status == 200) {
        
                            this.journal.releases.splice(this.journal.releases.indexOf(event), 1);
                            this.allReleases = this.journal.releases;
                            toast.fire({
                                type: 'success',
                                title: 'Numéro supprimé'
                            })

                            this.isChecked = !this.isChecked
                            this.filterReleasesClick()
                        }

                        if (response.data.status == 404) {
                            swal2.fire({
                                type: 'error',
                                title: 'Numéro introuvable..',
                                allowOutsideClick: false,
                                showConfirmButton: true,
                                confirmButtonText: 'Fermer'


                            });
                        }
                    })


            },
            affectValue(release) {
                this.release = release
                let element = this.$refs.modal
                $(element).modal('show')
            }

        }

    }

</script>
