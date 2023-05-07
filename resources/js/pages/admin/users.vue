<template>
  <v-card shaped class=" mx-auto vue__page_admin_users w-100">
    <v-simple-table>
      <template v-slot:default>
        <thead>
        <tr>
          <th>Id</th>
          <th>Имя</th>
          <th>Активный</th>
          <th>Часы</th>
          <th>Бонусные часы</th>
          <th>Управление</th>
        </tr>
        </thead>
        <tbody v-for="user in users">
        <tr>
          <td>{{ user.id }}</td>
          <td><i v-if="isAdmin(user)" class="fas fa-user-shield"/>{{ user.name }}</td>
          <td>
            <v-chip
                class="ma-2"
                :color="user.is_active ? $green : $blue"
            >
              {{ user.is_active ? 'Да' : 'Нет' }}
            </v-chip>
          </td>
          <td>
            <v-btn :color="$green" fab x-small @click="setHours(user.id,'hours',+1)">
              <i class="fa-solid fa-plus"></i>
            </v-btn>
            {{ user.hours }}
            <v-btn :color="$green" fab x-small @click="setHours(user.id,'hours',-1)">
              <i class="fa-solid fa-minus"></i>
            </v-btn>
          </td>
          <td>
            <v-btn :color="$green" fab x-small @click="setHours(user.id,'bonus_hours',+1)">
              <i class="fa-solid fa-plus"></i>
            </v-btn>
            {{ user.bonus_hours }}
            <v-btn :color="$green" fab x-small @click="setHours(user.id,'bonus_hours',-1)">
              <i class="fa-solid fa-minus"></i>
            </v-btn>

          </td>
          <td>
            <v-btn :color="$green" fab x-small @click="setActive(user.id)"><i style="font-size: 17px;"
                                                                              class="fab fa-creative-commons-sa"
            />
            </v-btn>
            <v-btn v-if="!isAdmin(user)" :color="$green" fab x-small @click="setAdmin(user.id)"><i
                style="font-size: 17px;"
                class="fas fa-user-shield"
            />
            </v-btn>
            <v-btn :color="$red" fab x-small @click="deleteUser(user.id)"><i style="font-size: 17px;"
                                                                             class="fas fa-user-times"
            />

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


function initialState () {
  return {
    users: []
  }
}

export default {
  name: 'users',
  middleware: [ 'admin', 'auth' ],
  data () {
    return initialState()
  },
  mounted () {
    this.getUsers()
  },
  methods: {
    getUsers () {
      axios({
        method: 'GET',
        url: '/api/admin/user',
      }).then((r) => {
        this.users = r.data
      })
    },
    setActive (userId) {
      axios({
        method: 'POST',
        url: '/api/admin/user/active/' + userId,
      }).then((r) => {
        this.getUsers()
        this.$notif(r)
      })
    },

    async setAdmin (userId) {
      const { data } = await axios({
        method: 'POST',
        url: '/api/admin/user/admin/' + userId,
      })
      this.getUsers()
      this.$notif(data)
    },

    async deleteUser (userId) {
      const { data } = await axios({
        method: 'POST',
        url: '/api/admin/user/delete/' + userId,
      })
      this.getUsers()
      this.$notif(data)
    },

    async setHours (userId, hoursType, hours) {
      const { data } = await axios({
        method: 'POST',
        url: '/api/admin/user/set-hours',
        data: {
          user_id: userId,
          hours_type: hoursType,
          hours: hours,
        }
      })
      this.getUsers()
    },

    isAdmin (user) {
      var checkResult = false
      user.roles.map(item => {
        if ( item.id === 1 ) {
          checkResult = true
        }
      })
      return checkResult
    }
  }
}
</script>

<style scoped>

</style>
