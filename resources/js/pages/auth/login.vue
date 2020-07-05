<template>
  <div class="row">
    <div class="col-lg-6 m-auto">
      <card title="Войти">
        <form @submit.prevent="login" @keydown="form.onKeydown($event)">
          <!-- Email -->
          <div class="pl-5 pr-5">
            <v-text-field :color="$blue" label="E-mail" v-model="form.email" name="email"
                          :error="form.errors.errors.email !== undefined"
                          :error-messages="form.errors.errors.email"
            />
          </div>

          <!-- Password -->
          <div class="pl-5 pr-5">
            <v-text-field :color="$blue" label="Пароль" v-model="form.password" type="password" name="password"
                          :error="form.errors.errors.password !== undefined"
                          :error-messages="form.errors.errors.password"
            />
          </div>

          <!-- Remember Me -->
          <div class="form-group row mb-0">
            <div class="col-md-12 pl-5 pr-5 d-flex">
              <v-checkbox
                v-model="remember" name="remember" :color="$blue"
                label="Запомнить меня"
              />
              <router-link :to="{ name: 'password.request' }" class="small ml-auto my-auto">
                {{ $t('forgot_password') }}
              </router-link>
            </div>
          </div>

          <div class="form-group row">
            <div class="col-md-12 d-flex justify-content-center">
              <v-btn :color="$blue" type="submit" :loading="form.busy">Войти</v-btn>
            </div>
          </div>
        </form>
      </card>
    </div>
  </div>
</template>

<script>
  import Form from 'vform'
  import LoginWithGithub from '~/components/LoginWithGithub'

  export default {
    middleware: 'guest',

    components: {
      LoginWithGithub
    },

    metaInfo() {
      return { title: this.$t( 'login' ) }
    },

    data: () => ( {
      form: new Form( {
        email: '',
        password: ''
      } ),
      remember: false
    } ),

    methods: {
      async login() {
        // Submit the form.
        const { data } = await this.form.post( '/api/login' )

        // Save the token.
        this.$store.dispatch( 'auth/saveToken', {
          token: data.token,
          remember: this.remember
        } )

        // Fetch the user.
        await this.$store.dispatch( 'auth/fetchUser' )

        // Redirect home.
        this.$router.push( { name: 'home' } )
      }
    }
  }
</script>
