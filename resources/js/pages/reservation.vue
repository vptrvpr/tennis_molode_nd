<template>
  <v-card shaped class="d-inline-block mx-auto vue__page__reservation w-100 d-flex justify-content-center">
    <v-app>
      <div class="row">
        <div class="col-md-12 text-center">
          <h6>Запись на муниципальные теннисные корты</h6>
        </div>
        <div class="col-md-4 pt-1 pb-0"></div>
        <div class="col-md-4 pt-1 pb-0 d-flex justify-content-center date-picker-for-reservation">
          <v-dialog
            ref="dialog"
            v-model="modal"
            :return-value.sync="date"
            persistent
            width="290px"
          >
            <template v-slot:activator="{ on, attrs }">
              <v-text-field
                v-model="date"
                readonly
                v-bind="attrs"
                v-on="on"
              />
            </template>
            <v-date-picker :first-day-of-week="1" v-model="date" scrollable>
              <v-spacer/>
              <v-btn text color="primary" @click="modal = false">Отмена</v-btn>
              <v-btn text color="primary" @click="$refs.dialog.save(date)">Ок</v-btn>
            </v-date-picker>
          </v-dialog>
        </div>
        <div class="col-md-4 pt-1 pb-0"></div>
        <div class="col-md-4 pt-1 pb-0"></div>
        <div class="col-md-4 pt-1 pb-0 d-flex justify-content-center">
          <v-alert v-if="reservationHours.length >= 2" type="warning">
            Нельзя забронировать больше 2-х часов в день!
          </v-alert>
          <v-btn v-else @click="dialog= true"
                 :disabled="selectedHours.length === 0 ? true : false"
                 :color="$blue">
            Забронировать
          </v-btn>
        </div>

        <div class="col-md-4 pt-1 pb-0"></div>
        <div class="col-md-2"></div>
        <div class="col-md-8 pt-1 pb-2">
          <v-simple-table>
            <template v-slot:default>
              <thead>
              <tr>
                <th class="text-center"/>
                <th class="text-center" v-for="hours in hoursForTable">
                  {{hours}}
                </th>
              </tr>
              </thead>
              <tbody>
              <template v-for="(court,courtKey)  in courts">
                <tr>
                  <td>{{court.name}}</td>
                  <template v-for="(hour,hourKey) in court.hours">
                    <v-menu
                      nudge-bottom="30"
                      :content-class="!hour.is_reservation ? 'box-shadow-none' : ''"
                      open-on-hover
                      bottom
                      :attach="`#tdWithHour${court.id}${hour.hour}`"
                    >
                      <template v-slot:activator="{ on, attrs }">
                        <td v-bind="attrs"
                            v-on="on"
                            class="1"
                            :id="`tdWithHour${court.id}${hour.hour}`"
                        >
                          <v-btn class="button-for-reservation"
                                 @mousedown="selectHour(courtKey,hourKey)"
                                 :disabled="hour.is_reservation"
                                 elevation="0"
                                 :color="hour.is_select ? $green : $blue"
                                 tile x-small>
                          </v-btn>
                        </td>
                      </template>
                      <v-list v-if="hour.is_reservation">
                        <div class="p-1">
                          Коммент: {{hour.comment}}<br>
                          Моб. телефон: {{hour.phone_number}}<br>
                          Дата бронирования: {{ $moment(hour.created_at).format('D.MM.YYYY hh:mm:ss')}}
                        </div>
                      </v-list>
                    </v-menu>
                  </template>
                </tr>
              </template>
              </tbody>
            </template>
          </v-simple-table>
        </div>
      </div>
    </v-app>
    <v-dialog v-model="dialog" persistent max-width="400">
      <v-card>
        <v-card-text>
          <div class="row">
            <div class="col-md-12">
              <v-text-field label="Имя и фамилия" :color="$blue" v-model="newReservation.fio"
                            placeholder="Обязательно"/>
            </div>
            <div class="col-md-12">
              <v-text-field label="Код" :color="$blue" v-model="newReservation.code"
                            placeholder="Обязательно"/>
            </div>
          </div>
        </v-card-text>
        <v-card-actions>
          <v-spacer/>
          <v-btn color="green darken-1" text @click="dialog = false">Отмена</v-btn>
          <v-btn color="green darken-1" text @click="reservation()">Забронировать</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </v-card>

</template>

<script>
  import axios from 'axios'
  import moment from 'moment'
  import UserIdMixin from "../mixins/user-id-mixin"


  function initialState() {
    return {
      courts: [
        { name: 'Корт №1', hours: [] },
        { name: 'Корт №2', hours: [] },
      ],
      date: moment().format( 'YYYY-MM-D' ),
      menu: false,
      modal: false,
      menu2: false,
      selectedHours: [],
      reservationHours: [],
      dialog: false,
      newReservation: {
        fio: '',
        code: '',
      },
      hoursForTable: []
    }
  }


  export default {
    name: "reservation.vue",
    mixins: [UserIdMixin],
    data() {
      return initialState()
    },
    mounted() {
      this.getCourts()
    },
    watch: {
      courtsJSON() {
        this.selectedHours = []
        this.reservationHours = []

        this.courts.map( ( court, courtKey ) => {
          court.hours.map( ( hour, hourKey ) => {
            if ( hour.user_id === this.userId && hour.is_select ) {
              this.selectedHours.push( {
                court_name: court.name,
                hour: hour.hour,
                court_key: courtKey,
                hour_key: hourKey,
              } );
            }
            if ( hour.user_id === this.userId && hour.is_reservation ) {
              this.reservationHours.push( {
                court_name: court.name,
                hour: hour.hour,
                court_key: courtKey,
                hour_key: hourKey,
              } );
            }
          } )
        } )
      },
      date() {
        this.getCourts()
      }
    },
    computed: {
      courtsJSON() {
        return JSON.stringify( this.courts )
      },
    },
    methods: {
      getCourts() {
        axios( {
          url: '/api/court/get',
          method: 'GET',
          params: { date: this.date }
        } ).then( ( r ) => {
          this.courts = r.data.courts
          this.hoursForTable = r.data.headers
        } )
      },

      reservation() {
        axios( {
          url: '/api/court/reservation',
          method: 'POST',
          data: {
            courts: this.courts, date: this.date, user_id: this.userId,
            fio: this.newReservation.fio,
            code: this.newReservation.code
          }
        } ).then( ( r ) => {
          this.getCourts()
          this.dialog = false
          this.newReservation = initialState().newReservation
        } )
      },

      selectHour( courtKey, hourKey ) {
        if ( this.selectedHours.length >= 2 ) {
          var deleteHour1 = this.selectedHours[ 0 ]
          var deleteHour2 = this.selectedHours[ 1 ]
          this.courts[ deleteHour1.court_key ].hours[ deleteHour1.hour_key ].user_id = null
          this.courts[ deleteHour1.court_key ].hours[ deleteHour1.hour_key ].is_select = false
          this.courts[ deleteHour2.court_key ].hours[ deleteHour2.hour_key ].user_id = null
          this.courts[ deleteHour2.court_key ].hours[ deleteHour2.hour_key ].is_select = false
        } else {
          this.courts[ courtKey ].hours[ hourKey ].user_id = this.userId
          this.courts[ courtKey ].hours[ hourKey ].is_select = !this.courts[ courtKey ].hours[ hourKey ].is_select
        }
      }
    },
  }
</script>
