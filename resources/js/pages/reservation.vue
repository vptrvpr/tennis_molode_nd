<template>
  <v-card shaped class="d-inline-block mx-auto vue__page__reservation w-100 d-flex justify-content-center">
    <v-app>
      <div class="row">
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
            <v-date-picker v-model="date" scrollable>
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
          <v-btn v-else @click="reservation"
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
                      transition="slide-y-transition"
                      nudge-bottom="40"
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
                          Имя: {{hour.user.name}}<br>
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
  </v-card>

</template>

<script>
  import axios from 'axios'
  import AuthMixin from "../mixins/auth-mixin";
  import moment from 'moment'


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
    }
  }


  export default {
    name: "reservation.vue",
    mixins: [AuthMixin],
    data() {
      return initialState()
    },
    mounted() {
      this.getCourts()
    },
    computed: {
      hoursForTable() {
        var hours = [];

        for ( var i = 9; i < 22; i++ ) {
          hours.push( `${i < 10 ? `0${i}-${i + 1}` : `${i}-${i + 1}`}` )
        }

        return hours
      },
      selectedHours() {
        var selectedHours = []

        this.courts.map( ( court, courtKey ) => {
          court.hours.map( ( hour, hourKey ) => {
            if ( hour.user_id === this.authUser.id && hour.is_select ) {
              selectedHours.push( {
                court_name: court.name,
                hour: hour.hour,
                court_key: courtKey,
                hour_key: hourKey,
              } );
            }
          } )
        } )

        return selectedHours
      },
      reservationHours() {
        var reservationHours = []

        this.courts.map( ( court, courtKey ) => {
          court.hours.map( ( hour, hourKey ) => {
            if ( hour.user_id === this.authUser.id && hour.is_reservation ) {
              reservationHours.push( {
                court_name: court.name,
                hour: hour.hour,
                court_key: courtKey,
                hour_key: hourKey,
              } );
            }
          } )
        } )

        return reservationHours
      }
    },
    methods: {
      getCourts() {
        axios( {
          url: '/api/court/get',
          method: 'GET',
          params: { date: this.date }
        } ).then( ( r ) => {
          this.courts = r.data
        } )
      },

      reservation() {
        axios( {
          url: '/api/court/reservation',
          method: 'POST',
          data: { courts: this.courts, date: this.date }
        } ).then( ( r ) => {
          this.getCourts()
        } )
      },

      selectHour( courtKey, hourKey ) {
        if ( ( this.selectedHours.length === 2 ) || ( this.selectedHours.length === 1 && this.reservationHours.length === 1 ) ) {
          var deleteHour = this.selectedHours[ this.selectedHours.length - 1 ]
          this.courts[ deleteHour.court_key ].hours[ deleteHour.hour_key ].user_id = null
          this.courts[ deleteHour.court_key ].hours[ deleteHour.hour_key ].is_select = false
        }
        this.courts[ courtKey ].hours[ hourKey ].user_id = this.authUser.id
        this.courts[ courtKey ].hours[ hourKey ].is_select = !this.courts[ courtKey ].hours[ hourKey ].is_select
      }
    },
  }
</script>
