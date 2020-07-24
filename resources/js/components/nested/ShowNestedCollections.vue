<template>
    <div class="container mt-4 mb-4">
        <div class="form-group mt-2">
            <div class="d-flex flex-row bd-highlight">
                <div class="p-2 bd-highlight">
                    <h3 class="font-weight-normal">Collections</h3>
                </div>

            </div>
        </div>
        <table class="table table-bordered table-hover  table-responsive-md mb-3 ">
            <thead>
                <tr>
                    <th scope="col">Photo</th>
                    <th scope="col">Name</th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="collection in this.formattedCollections">

                  

                                 <td class="style-image">
                                <div class="container">
                                    <img :src="collection.photo ? collection.photo : '/img/placeholder.jpg'" alt=""
                                        class="img-fluid">
                                </div>


                            </td>
                    <td>{{collection.name}}</td>

   

                    <td style="width:5%;">
                        <div class="form-check mt-1">
                            <input class="form-check-input" type="checkbox" @click="matchCollection(collection.id)"
                                :checked="collection.selected"></div>
                    </td>
                    <show-modal :element="collection" v-on:requiredValue="updateCollections($event)"></show-modal>
                </tr>

            </tbody>
        </table>

    </div>

</template>

<script>
    export default {
        mounted() {

            this.collections.forEach(collection => {

                this.formattedCollections.push({
                        id: collection.id,
                        photo: collection.photo,
                        name: collection.name,
             
                        selected: false

                    })
            })
            if (this.oldSelectedCollections && this.oldSelectedCollections.length > 0) {
                this.selectedCollections = this.oldSelectedCollections
                this.formattedCollections.forEach(formattedcollection => {
                        this.oldSelectedCollections.forEach(selectedcollection => {

                                if (formattedcollection.id == selectedcollection) {

                                    formattedcollection.selected = true;
                                }

                            })
                    })

                     

            }

        },
        props: [
            'collections', 'oldSelectedCollections'
        ],
        data() {
            return {
                formattedCollections: [],
                selectedCollections: []
            }

        },
        methods: {
            matchCollection(id) {

                let isSelected = false;
                this.formattedCollections.forEach(collection => {
                        if (collection.id == id) {
                            collection.selected = !collection.selected
                            isSelected = !collection.selected

                        }

                    })

                if (!isSelected) {
                    toast.fire({
                        icon: 'success',
                        title: 'Collection selected'
                    })
                    this.selectedCollections.push(id)
                 
                    this.$emit('submitCollections', this.selectedCollections)

                } else {
                    toast.fire({
                        icon: 'success',
                        title: 'Collection removed'
                    })
                 
                    this.selectedCollections = this.selectedCollections.filter(selectedId => {
                            return selectedId != id;
                        })
                       
                       

                    this.$emit('submitCollections', this.selectedCollections)
                }

            }

        }

    }

</script>
