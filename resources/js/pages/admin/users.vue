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
                    <td><i v-if="isAdmin(user)" class="fas fa-user-shield"/>{{user.name}}</td>
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
                                                                                          class="fab fa-creative-commons-sa"/>
                        </v-btn>
                        <v-btn v-if="!isAdmin(user)" :color="$green" fab x-small @click="setAdmin(user.id)"><i style="font-size: 17px;"
                                                                                         class="fas fa-user-shield"/>
                        </v-btn>
                        <v-btn :color="$red" fab x-small @click="deleteUser(user.id)"><i style="font-size: 17px;"
                                                                                         class="fas fa-user-times"/>

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
            },

            async setAdmin( userId ) {
                const { data } = await axios( {
                    method: 'POST',
                    url: '/api/admin/user/admin/' + userId,
                } )
                this.getUsers()
                this.$notif( data )
            },

            async deleteUser( userId ) {
                const { data } = await axios( {
                    method: 'POST',
                    url: '/api/admin/user/delete/' + userId,
                } )
                this.getUsers()
                this.$notif( data )
            },


            isAdmin( user ) {
                var checkResult = false
                user.roles.map( item => {
                    if ( item.id === 1 ) {
                        checkResult = true
                    }
                } )
                return checkResult
            }
        }
    }
</script>

<style scoped>

</style>
