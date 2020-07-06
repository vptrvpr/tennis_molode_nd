<template>
  <nav class="navbar navbar-expand-lg navbar-light" style="height: 100px;">
    <div class="container">
      <a href="http://molodnd.ru/" class="navbar-brand">
        <img src="/img/Bely_logo.png" height="90px">
      </a>

      <!--      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarToggler"-->
      <!--              aria-controls="navbarToggler" aria-expanded="false">-->
      <!--        <span class="navbar-toggler-icon"/>-->
      <!--      </button>-->
      <!---->
      <!--      <div id="navbarToggler" class="collapse navbar-collapse">-->
      <!--        <ul class="navbar-nav">-->
      <!--          <locale-dropdown/>-->
      <!--          &lt;!&ndash; <li class="nav-item">-->
      <!--            <a class="nav-link" href="#">Link</a>-->
      <!--          </li> &ndash;&gt;-->
      <!--        </ul>-->
      <!---->
      <ul class="navbar-nav ml-auto">
        <!--          Authenticated-->
        <li v-if="user.id" class="nav-item dropdown">
          <a class="nav-link dropdown-toggle text-dark"
             href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
          >
            <i class="fas fa-user-shield"></i>
            <img :src="user.photo_url" class="rounded-circle profile-photo mr-1">
            {{ user.name }}
          </a>
          <div class="dropdown-menu">
            <router-link :to="{ name: 'settings.profile' }" class="dropdown-item pl-3">
              <fa icon="cog" fixed-width/>
              Настройка
            </router-link>

            <div class="dropdown-divider"/>
            <a href="#" class="dropdown-item pl-3" @click.prevent="logout">
              <fa icon="sign-out-alt" fixed-width/>
              Выйти
            </a>
          </div>
        </li>
        <!--          Guest-->
        <template v-else>
          <li class="nav-item">
            <router-link :to="{ name: 'login' }" class="nav-link" active-class="active">
              Войти
            </router-link>
          </li>
          <li class="nav-item">
            <router-link :to="{ name: 'register' }" class="nav-link" active-class="active">
              Регистрация
            </router-link>
          </li>
        </template>
      </ul>
    </div>
    <preloader/>
    <notifications group="all"/>
  </nav>
</template>

<script>
  import { mapGetters } from 'vuex'
  import LocaleDropdown from './LocaleDropdown'
  import Preloader from "./Preloader";

  export default {
    components: {
      Preloader,
      LocaleDropdown
    },

    data: () => ( {
      appName: window.config.appName
    } ),

    computed: mapGetters( {
      user: 'auth/user'
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
  .profile-photo {
    width: 2rem;
    height: 2rem;
    margin: -.375rem 0;
  }

  .navbar {
    background: url("/img/shapka_zapisi.png");
    background-position: center;
    background-size: cover;
  }
</style>
