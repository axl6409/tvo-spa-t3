<template>
    <card :title="$t('your_info')">
        <p></p>
    </card>
</template>

<script>
    import Form from 'vform'
    import { mapGetters } from 'vuex'

    export default {
        scrollToTop: false,

        metaInfo () {
            return { title: this.$t('settings') }
        },

        data: () => ({
            user: new Form({
                name: '',
                email: ''
            })
        }),

        computed: mapGetters({
            user: 'auth/user'
        }),

        created () {

        },

        methods: {

        }
    }
</script>
