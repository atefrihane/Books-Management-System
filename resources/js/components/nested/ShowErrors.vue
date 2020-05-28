<template>

    <div>
        <div class="alert alert-danger mb-3" v-for="error in errors">


            <strong>Oups!</strong>&nbsp; {{error}}

        </div>

    </div>

</template>

<script>
    export default {
        mounted() {
            console.log('Component mounted.')
        },
        props: ['errors'],

    }

</script>
