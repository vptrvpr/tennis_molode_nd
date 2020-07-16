<template>
  <div>
    <div class="text-center">
      <div class="title mb-4">
        неактивный
      </div>
      <v-btn :color="$red" @click.prevent="logout">Выйти</v-btn>
    </div>
  </div>
</template>

<script>
  import { mapGetters } from 'vuex'

  export default {
    layout: 'basic',
    middleware: ['auth'],

    metaInfo() {
      return { title: this.$t( 'home' ) }
    },

    data: () => ( {
      title: window.config.appName
    } ),

    computed: mapGetters( {
      authenticated: 'auth/check'
    } ),

    methods: {
      async logout() {
        // Log out the user.
        await this.$store.dispatch( 'auth/logout' )

        // Redirect to login.
        this.$router.push( { name: 'login' } )
      }
    }
  }
</script>

<style scoped>
  .top-right {
    position: absolute;
    right: 10px;
    top: 18px;
  }

  .title {
    font-size: 85px;
  }
</style>
