<template>
  <div class="row">
    <div class="col-lg-8 m-auto">
      <card :title="$t('login')">
        <form @submit.prevent="login" @keydown="form.onKeydown($event)">
          <div class="form-group row">
            <div class="col-md-7 d-flex">
              <login-with-bungie />
            </div>
          </div>
        </form>
      </card>
    </div>
  </div>
</template>

<script>
import Form from 'vform'
import LoginWithBungie from '~/components/LoginWithBungie'

export default {
  middleware: 'guest',

  components: {
    LoginWithBungie
  },

  metaInfo () {
    return { title: this.$t('login') }
  },

  data: () => ({
    form: new Form({
    })
  }),

  methods: {
    async login () {
      // Submit the form.
      const { data } = await this.form.post('/api/login')

      // Save the token.
      this.$store.dispatch('auth/saveToken', {
        token: data.token,
        remember: this.remember
      })

      // Fetch the user.
      await this.$store.dispatch('auth/fetchUser')

      // Redirect home.
      this.$router.push({ name: 'characters' })
    }
  }
}
</script>
