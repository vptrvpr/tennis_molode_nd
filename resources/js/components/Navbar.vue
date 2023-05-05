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
        <li v-if="user.id" class="nav-item dropdown" id="btnDropDownLogout">
          <v-menu bottom nudge-bottom="45" attach="#btnDropDownLogout">
            <template v-slot:activator="{ on, attrs }">
              <a class="nav-link dropdown-toggle text-dark"
                 v-bind="attrs"
                 v-on="on"
                 href="#" role="button"
              >
                <svg v-if="user.checkRole(1)" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                     viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                     stroke-linejoin="round" class="feather feather-user-check"
                >
                  <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                  <circle cx="8.5" cy="7" r="4"/>
                  <polyline points="17 11 19 13 23 9"/>
                </svg>
                <img :src="user.photo_url" class="rounded-circle profile-photo mr-1">
                {{ user.name }}
              </a>
              <div style="font-size: 12px;text-align: right">
                <span>Часы: {{ user.hours }}</span><br>
                <span>Бонусные часы: {{ user.bonus_hours }}</span>
              </div>

            </template>

            <v-list>
              <v-list-item :to="{ name: 'settings.profile' }">
                <v-list-item-title>Настройка</v-list-item-title>
              </v-list-item>
              <v-list-item @click.prevent="logout">
                <v-list-item-title>Выйти</v-list-item-title>
              </v-list-item>
            </v-list>
          </v-menu>
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
import Preloader from './Preloader'

export default {
  components: {
    Preloader,
    LocaleDropdown
  },

  data: () => ({
    appName: window.config.appName
  }),

  computed: mapGetters({
    user: 'auth/user'
  }),

  methods: {
    async logout () {
      // Log out the user.
      await this.$store.dispatch('auth/logout')

      // Redirect to login.
      this.$router.push({ name: 'login' })
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
