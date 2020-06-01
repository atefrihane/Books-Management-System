<template>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Would you like to delete this element  ?
                    </h5>

                </div>

                <div class="modal-footer">
                    <a href="#" data-dismiss="modal" class="btn btn-danger">Cancel</a>
                    <a href="#" data-dismiss="modal" class="btn btn-primary"
                        @click="deleteElement()">Confirm</a>

                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        mounted() {
            
            console.log('Component mounted.')
        },
        props: ['element'],
        data() {
            return {
                

            }
        },
        methods: {
            deleteElement(element) {
               
                this.$emit('removeItem', this.element)

            }


        }
    }

</script>
