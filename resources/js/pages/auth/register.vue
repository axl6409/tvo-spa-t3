<template>
  <div class="row">
    <div class="col-lg-6 m-auto">
      <card :title="$t('register')">
        <h3>Vous devez avoir un compte Bungie.net pour pouvoir vous connecter au site !</h3>
        <form class="form-log" @submit.prevent="register" @keydown="form.onKeydown($event)">
          <div class="form-group row">
            <div class="col-md-12 d-flex">
              <!-- GitHub Register Button -->
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
    return { title: this.$t('register') }
  },

  data: () => ({
    form: new Form({
    }),
    mustVerifyEmail: false
  }),

  methods: {
    async register () {
      // Register the user.
      const { data } = await this.form.post('/api/register')
      console.log(data)

      // Must verify email fist.
      if (data.status) {
        this.mustVerifyEmail = true
      } else {
        // Log in the user.
        const { data: { token } } = await this.form.post('/api/login')

        // Save the token.
        this.$store.dispatch('auth/saveToken', { token })

        // Update the user.
        await this.$store.dispatch('auth/updateUser', { user: data })

        // Redirect Characters Page.
        this.$router.push({ name: 'characters' })
      }
    }
  }
}
</script>
