<template>
  <v-card shaped class=" mx-auto vue__page_admin_users w-100">
    <v-simple-table>
      <template v-slot:default>
        <thead>
        <tr>
          <th>Id</th>
          <th>Имя</th>
          <th>Активный</th>
          <th>Управление</th>
        </tr>
        </thead>
        <tbody v-for="user in users">
        <tr>
          <td>{{user.id}}</td>
          <td>{{user.name}}</td>
          <td>
            <v-chip
              class="ma-2"
              :color="user.is_active ? $green : $blue"
            >
              {{user.is_active ? 'Да' : 'Нет'}}
            </v-chip>
          </td>
          <td>
            <v-btn :color="$green" fab x-small @click="setActive(user.id)"><i style="font-size: 17px;"
                                                                              class="fab fa-creative-commons-sa"></i>
            </v-btn>
          </td>
        </tr>
        </tbody>
      </template>
    </v-simple-table>
  </v-card>
</template>

<script>
  import axios from 'axios'


  function initialState() {
    return {
      users: []
    }
  }

  export default {
    name: "users",
    middleware: ['admin', 'auth'],
    data() {
      return initialState()
    },
    mounted() {
      this.getUsers()
    },
    methods: {
      getUsers() {
        axios( {
          method: 'GET',
          url: '/api/admin/user',
        } ).then( ( r ) => {
          this.users = r.data
        } )
      },
      setActive( userId ) {
        axios( {
          method: 'POST',
          url: '/api/admin/user/active/' + userId,
        } ).then( ( r ) => {
          this.getUsers()
          this.$notif( r )
        } )
      }
    }
  }
</script>

<style scoped>

</style>
