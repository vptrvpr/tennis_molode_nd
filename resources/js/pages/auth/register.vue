<template>
  <div class="row">
    <div class="col-lg-6 m-auto">
      <card v-if="mustVerifyEmail" title="Регистрация">
        <div class="alert alert-success" role="alert">
          {{ $t('verify_email_address') }}
        </div>
      </card>
      <card v-else title="Регистрация">
        <form @submit.prevent="register" @keydown="form.onKeydown($event)">
          <!-- Name -->
          <div class="pl-5 pr-5">
            <v-text-field :color="$blue" label="Имя и фамилия" v-model="form.name" name="name"
                          :error="form.errors.errors.name !== undefined"
                          :error-messages="form.errors.errors.name"
            />
          </div>


          <!-- Email -->
          <div class="pl-5 pr-5">
            <v-text-field :color="$blue" label="E-mail" v-model="form.email" name="email"
                          :error="form.errors.errors.email !== undefined"
                          :error-messages="form.errors.errors.email"
            />
          </div>

          <div class="pl-5 pr-5">
            <v-text-field :color="$blue" label="Пароль" v-model="form.password" name="password"
                          type="password"
                          :error="form.errors.errors.password !== undefined"
                          :error-messages="form.errors.errors.password"
            />
          </div>

          <div class="pl-5 pr-5">
            <v-text-field :color="$blue" label="Повторите пароль" v-model="form.password_confirmation"
                          name="password_confirmation"
                          type="password"
                          :error="form.errors.errors.password_confirmation !== undefined"
                          :error-messages="form.errors.errors.password_confirmation"
            />
          </div>

          <div class="form-group row">
            <div class="col-md-7 offset-md-3 d-flex">
              <v-btn :color="$blue" type="submit" :loading="form.busy">Зарегистрироваться</v-btn>
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
      return { title: this.$t( 'register' ) }
    },

    data: () => ( {
      form: new Form( {
        name: '',
        email: '',
        password: '',
        password_confirmation: ''
      } ),
      errors: {},
      mustVerifyEmail: false
    } ),

    methods: {
      async register() {
        // Register the user.
        const { data } = await this.form.post( '/api/register' )

        // Must verify email fist.
        if ( data.status ) {
          this.mustVerifyEmail = true
        } else {
          // Log in the user.
          const { data: { token } } = await this.form.post( '/api/login' )

          // Save the token.
          this.$store.dispatch( 'auth/saveToken', { token } )

          // Update the user.
          await this.$store.dispatch( 'auth/updateUser', { user: data } )

          // Redirect home.
          this.$router.push( { name: 'home' } )
        }
      }
    }
  }
</script>
