<template>
  <div>
    <v-card shaped class="d-inline-block mx-auto vue__page__reservation w-100 d-flex justify-content-center">
      <v-app>
        <div class="row">
          <div class="col-md-12 text-center">
            <h6>Запись на муниципальные теннисные корты</h6>
          </div>
          <div style="display: grid;justify-content: center;width: 100%;">
            <v-btn style="color: rgb(33, 150, 243) !important" :color="$blue" target="_blank"
                   :href="'/storage/file-links/'+fileLink.file" text v-for="fileLink in fileLinks"
            >
              {{ fileLink.name }}
            </v-btn>
            <br>
          </div>
          <div class="col-md-12 d-flex justify-content-center">
            <div class="d-flex">
              <v-btn class="btn-reservation-info"
                     elevation="0"
                     :color="$red"
                     tile x-small
              >
                <i style="font-size: 20px;" class="fas fa-times"/>
              </v-btn>
              <h6 class="ml-1 mt-1">- Отменить</h6>
            </div>
            <div class="d-flex ml-2">
              <v-btn class="btn-reservation-info"
                     elevation="0"
                     disabled
                     :color="$red"
                     tile x-small
              >
              </v-btn>
              <h6 class="ml-1 mt-1">- Занято</h6>
            </div>
            <div class="d-flex ml-2">
              <v-btn class="btn-reservation-info"
                     elevation="0"
                     :color="$blue"
                     tile x-small
              >
              </v-btn>
              <h6 class="ml-1 mt-1">- Свободно</h6>
            </div>
          </div>
          <div class="col-md-4 pt-1 pb-0 d-flex justify-content-center">
          </div>
          <div class="col-md-4 pt-1 pb-0 d-flex justify-content-center date-picker-for-reservation">
            <v-btn @click="changeWeek('sub')" class="mt-4" fab text :color="$blue" x-small><i
                style="font-size: 19px"
                class="fas fa-chevron-left"
            />
            </v-btn>
            <v-text-field hide-details class="input-week-picker" v-model="weekForInput"
                          disabled :color="$blue"
            />
            <v-btn @click="changeWeek('add')" class="mt-4" fab text :color="$blue" x-small><i
                style="font-size: 19px"
                class="fas fa-chevron-right"
            />
            </v-btn>
          </div>
          <div class="col-md-4 pt-1 pb-0"></div>
          <div class="col-md-3 pt-1 pb-0"></div>
          <div class="col-md-6 mt-1 pt-1 pb-0 d-flex justify-content-center">
            <v-btn @click="dialog= true" v-if="authUser.id && authUser.is_active"
                   :disabled="selectedHours.length === 0 ? true : false"
                   :color="$blue"
            >
              Забронировать
            </v-btn>
            <v-alert type="warning" v-else-if="authUser.id && !authUser.is_active">
              Обратитесь к <a href="https://vk.com/yakov_nk" target="_blank">администратору</a>, для
              получения полномочий
            </v-alert>
            <v-btn v-else :color="$green" href="/login">
              ВОЙТИ
            </v-btn>
          </div>

          <div class="col-md-3 pt-1 pb-0"></div>
          <div class="col-md-2"></div>
          <div class="col-md-8 pt-1 pb-2">
            <v-simple-table fixed-header>
              <template v-slot:default>
                <thead>
                <tr>
                  <th colspan="1" class="text-center"/>
                  <th colspan="2" class="text-center" v-for="header in headersTable">
                    {{ header.name }}
                  </th>
                </tr>
                <tr>
                  <th colspan="1" class="text-center"/>
                  <template v-for="header in headersTable">
                    <th class="pl-1 pr-1 text-center" v-for="court in header.courts">
                      {{ court.name }}
                    </th>
                  </template>
                </tr>
                </thead>
                <tbody>
                <tr v-for="(hoursBy,key) in hours">
                  <td style="width: 36px;white-space: nowrap;">{{ getHours(key) }}</td>
                  <template v-for="(hour,hourKey) in hoursBy">
                    <template v-if="hour.is_reservation !== undefined">
                      <v-menu
                          nudge-left="0"
                          nudge-top="40"
                          :content-class="!hour.is_reservation ? 'box-shadow-none' : ''"
                          open-on-hover
                          left
                          :attach="`#tdWithHour${key}${hour.hour}`"
                      >
                        <template v-slot:activator="{ on, attrs }">
                          <td
                              v-bind="attrs"
                              v-on="on"
                              :class="(hourKey + 1) % 2 == 0 ? 'pr-2' : 'pl-2'"
                              :id="`tdWithHour${key}${hour.hour}`"
                              v-if="hour.is_reservation && hour.user_id === authUser.id || hour.is_reservation && hour.user_id && authUser.checkRole(1)
                          "
                          >
                            <v-btn class="button-for-reservation"
                                   elevation="0"
                                   @click="openDialogCancelReservation(hour.id)"
                                   :color="$red"
                                   tile x-small
                            >
                              <i style="font-size: 20px;" class="fas fa-times"/>
                            </v-btn>
                          </td>
                          <td
                              v-bind="attrs"
                              v-on="on"
                              v-else
                              :class="(hourKey + 1) % 2 == 0 ? 'pr-2' : 'pl-2'"
                              :id="`tdWithHour${key}${hour.hour}`"
                          >
                            <v-btn class="button-for-reservation"
                                   :disabled="hour.is_reservation"
                                   @click="selectHour(key,hourKey)"
                                   :style="{opacity: hour.is_reservation && !hour.user_id ? 0.5 : 1}"
                                   elevation="0"
                                   :color="hour.is_select ? $green : $blue"
                                   tile x-small
                            >
                            </v-btn>
                          </td>

                        </template>
                        <v-list v-if="hour.is_reservation && hour.user_id">
                          <div class="p-1">
                            {{ hour.user.name }}<br>
                            <template v-if="authUser.checkRole(1)">
                              {{ $moment(hour.created_at).format('DD.MM.YYYY hh:mm:ss') }}
                            </template>
                          </div>
                        </v-list>
                      </v-menu>
                    </template>
                    <template v-else>
                      <td/>
                    </template>

                  </template>
                </tr>
                </tbody>
              </template>
            </v-simple-table>
          </div>

          <div class="p-3 row">
            <div class="col-md-6 col-sm-12 justify-content-center" style="display: grid;">
              <h5 class="text-center">Корт 1</h5>
              <iframe src="http://www.cactus.tv:8080/cam24/embed.html" width="468" height="350" align="left">
                Ваш браузер не поддерживает плавающие фреймы!
              </iframe>
            </div>
            <div class="col-md-6 col-sm-12 justify-content-center" style="display: grid;">
              <h5 class="text-center">Корт 2</h5>
              <iframe src="http://www.cactus.tv:8080/cam25/embed.html" width="468" height="350" align="left">
                Ваш браузер не поддерживает плавающие фреймы!
              </iframe>
            </div>


          </div>

        </div>
      </v-app>
      <v-dialog v-model="dialog" persistent max-width="300">
        <v-card>
          <v-card-title class="text-center justify-content-center">Вы уверены ,что хотите<br> забронировать?
          </v-card-title>
          <v-card-actions>
            <v-btn color="green darken-1" large text @click="dialog = false">Нет</v-btn>
            <v-spacer/>
            <v-btn color="green darken-1" large text @click="reservation()">Да</v-btn>
          </v-card-actions>
        </v-card>
      </v-dialog>
      <v-dialog v-model="dialogCancelReservation" persistent max-width="300">
        <v-card>
          <v-card-title class="text-center justify-content-center">
            Вы уверены ,что хотите<br> отменить бронь?
          </v-card-title>
          <v-card-actions>
            <v-btn color="green darken-1" large text @click="dialogCancelReservation = false">Нет</v-btn>
            <v-spacer/>
            <v-btn color="green darken-1" large text @click="cancelReservation()">Да</v-btn>
          </v-card-actions>
        </v-card>
      </v-dialog>
    </v-card>


  </div>
</template>

<script>
import axios from 'axios'
import moment from 'moment'
import AuthMixin from '../mixins/auth-mixin'


function initialState () {
  return {
    weeks: [],
    date: moment().format('YYYY-MM-D'),
    weeksPicker: {
      1: moment().startOf('week'),
      2: moment().endOf('week'),
    },
    menu: false,
    modal: false,
    menu2: false,
    selectedHours: [],
    reservationHours: [],
    dialogCancelReservation: false,
    cancelReservationId: null,
    dialog: false,
    newReservation: {
      fio: '',
      code: '',
    },
    headersTable: [],
    hours: [],
    fileLinks: []
  }
}

export default {
  name: 'reservation.vue',
  mixins: [ AuthMixin ],
  middleware: [ 'is-active' ],
  data () {
    return initialState()
  },
  mounted () {
    this.getCourts()
    this.getFileLink()
  },
  methods: {
    async getFileLink () {
      const { data } = await axios({
        method: 'get',
        url: '/api/admin/file-links',
      })

      this.fileLinks = data
    },

    openDialogCancelReservation (id) {
      this.dialogCancelReservation = true
      this.cancelReservationId = id
    },

    cancelReservation () {
      axios({
        method: 'DELETE',
        url: '/api/court/reservation/' + this.cancelReservationId
      }).then(r => {
        this.$notif(r.data)
        this.getCourts()
        this.dialogCancelReservation = false
      })
    },

    changeWeek (type) {
      if ( type === 'sub' ) {
        this.weeksPicker = {
          1: this.weeksPicker[ 1 ].subtract(7, 'days'),
          2: this.weeksPicker[ 2 ].subtract(7, 'days'),
        }
      } else if ( type === 'add' ) {
        this.weeksPicker = {
          1: this.weeksPicker[ 1 ].add(7, 'days'),
          2: this.weeksPicker[ 2 ].add(7, 'days'),
        }
      }
    },

    getCourts () {
      axios({
        url: '/api/court/get',
        method: 'GET',
        params: { date: [ this.weeksPicker[ 1 ].format('YYYY-MM-DD'), this.weeksPicker[ 2 ].format('YYYY-MM-DD') ] }
      }).then((r) => {
        this.weeks = r.data.weeks
        this.headersTable = r.data.headers
        this.hours = r.data.hours
      })
    },

    reservation () {
      axios({
        url: '/api/court/reservation',
        method: 'POST',
        data: {
          hours: this.hours,
        }
      }).then((response) => {
        this.$notif(response.data)
        this.getCourts()
        this.dialog = false
      }).catch((error) => {
        this.dialog = false
      })
    },

    selectHour (hourKey, key) {
      if ( this.selectedHours.length >= 2 && !this.authUser.checkRole(1) ) {
        var deleteHour1 = this.selectedHours[ 0 ]
        var deleteHour2 = this.selectedHours[ 1 ]
        this.hours[ deleteHour1.hour_key ][ deleteHour1.key ].user_id = null
        this.hours[ deleteHour1.hour_key ][ deleteHour1.key ].is_select = false
        this.hours[ deleteHour2.hour_key ][ deleteHour2.key ].user_id = null
        this.hours[ deleteHour2.hour_key ][ deleteHour2.key ].is_select = false
      } else {
        this.hours[ hourKey ][ key ].user_id = this.authUser.id
        this.hours[ hourKey ][ key ].is_select = !this.hours[ hourKey ][ key ].is_select
      }
    },

    getHours (hour) {
      return `${hour < 10 ? 0 + hour : hour}-${parseInt(hour) + 1}`
    }
  },
  watch: {
    hoursJSON () {
      this.selectedHours = []
      this.reservationHours = []

      for ( const [ hourKey, hours ] of Object.entries(this.hours) ) {
        hours.map((item, key) => {
          if ( item.user_id === this.authUser.id && item.is_select ) {
            this.selectedHours.push({
              hour_key: hourKey,
              hour: item.hour,
              key: key,
            })
          }

          if ( item.user_id === this.authUser.id && item.is_reservation ) {
            this.reservationHours.push({
              hour_key: hourKey,
              hour: item.hour,
              key: key,
            })
          }
        })
      }
    },
    weekForInput () {
      this.getCourts()
    }
  },
  computed: {
    hoursJSON () {
      return JSON.stringify(this.hours)
    },
    weekForInput () {
      return `${this.weeksPicker[ 1 ].format('DD.MM.YYYY')} - ${this.weeksPicker[ 2 ].format('DD.MM.YYYY')}`
    }
  },
}
</script>
