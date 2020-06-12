<template>
    <div>
        Fetching users ...
    </div>
</template>

<script>
    import axios from 'axios'

    export default {

        data() {
            return {
                id: '',
                name: ''
            }
        },

        methods: {
          getUser() {
              axios.get('/api/user')
                    .then(response => response.data.id)
          },
          getCaracters() {
              axios.get('/api/{this.id}/caracters')
                    .then(response => response.data)
          }
        },

        mounted() {
            console.log(this.getCaracters())
        }
    }
</script>
