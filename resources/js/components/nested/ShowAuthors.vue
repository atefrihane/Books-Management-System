<template>
    <div>
        <div class="container mt-4">
            <div class="form-group mt-2">
                <div class="d-flex flex-row bd-highlight">
                    <div class="p-2 bd-highlight">
                        <h3 class="font-weight-normal">Authors</h3>
                    </div>



                </div>
            </div>

            <autocomplete :search="search" placeholder="Search authors.." aria-label="Chercher un auteur"
                :get-result-value="getResultValue" @submit="handleSubmit"></autocomplete>




            <div class="mt-4 border p-4" v-if="searchedAuthors.length > 0" v-for="author in searchedAuthors">
                <div class="row">
                    <div class="col-md-6"></div>
                    <div class="col-md-6">

                        <a class="float-right" @click="selectAuthor(author.id)"><i class="fas fa-check"
                                v-bind:class="[author.selected ? activeClass :  errorClass]"></i></a>
                    </div>
                </div>
                <div class="container">
                    <div class="row">
                        <div class="col-md-2 mb-3">
                            <img :src="author.photo" class="ml-3 mt-2 img-thumbnail" style="width:100%;">
                        </div>
                        <div class="col-md-8 ml-3">

                            <div class="row mt-2">
                                <div class="col-md-12">
                                    <h5>{{author.fullName}}</h5>
                                </div>
                            </div>

                            <div class="row mt-4">
                                <div class="col-md-12">

                                    <p>{{author.biography}}
                                    </p>
                                </div>
                            </div>

                        </div>



                    </div>
                </div>

            </div>
            <div class="mt-4 border p-4" v-if="searchedAuthors.length == 0">
                <h5 class="text-center">List will be displayed here.</h5>

            </div>
        </div>

    </div>


</template>

<script>
    import Autocomplete from '@trevoreyre/autocomplete-vue'
    import '@trevoreyre/autocomplete-vue/dist/style.css'

    Vue.use(Autocomplete)
    export default {
        mounted() {
            this.formatAuthors()
            if (this.oldSearchedAuthors && this.oldSearchedAuthors.length > 0) {
                this.searchedAuthors = this.oldSearchedAuthors
                this.selectedAuthors = _.map(this.oldSearchedAuthors, 'id');

            }



        },
        props: ['authors', 'oldSearchedAuthors'],
        data() {

            return {
                searchedAuthors: [],
                formattedAuthors: [],
                selectedAuthor: '',
                activeClass: 'active-class',
                errorClass: 'not-active-class'
            }
        },
        methods: {
            formatAuthors() {


                if (this.authors && this.authors.length > 0) {
                    this.authors.forEach(author => {
                        this.formattedAuthors.push({
                            id: author.id,
                            fullName: author.first_name + ' ' + author.last_name,
                            biography: author.biography,
                            photo: author.photo,
                            selected: false,

                        })
                    })

                }



            },
            search(input) {
                if (input.length < 1) {
                    return []
                }


                return this.formattedAuthors.filter(author => {
                    return author.fullName.toLowerCase()
                        .startsWith(input.toLowerCase())
                })
            },
            //
            // We want to display the name 
            getResultValue(result) {
                return result.fullName

            },
            handleSubmit(result) {
                if (result) {
                    let checkExistedAuthor = _.findIndex(this.searchedAuthors, function (o) {
                        return o.id == result.id;
                    });
                    if (checkExistedAuthor == -1) {
                        this.searchedAuthors.push(result)
                    }
                }



            },
            selectAuthor(id) {
          
                this.searchedAuthors.forEach(author => {
                    if (author.id == id) {
                        author.selected = !author.selected
                     
                    }
                    else{
                          author.selected = false
                    }
                })
              
                    toast.fire({
                        type: 'success',
                        title: 'Author selected'
                    })
                    this.selectedAuthor= id
                    this.$emit('matchAuthors', id)

              

            }
        }
    }

</script>
