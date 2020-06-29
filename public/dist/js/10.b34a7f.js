(window.webpackJsonp=window.webpackJsonp||[]).push([[10],{26:function(t,e,s){"use strict";s.r(e);var o=s(8),r=s.n(o),n=s(0),a=s.n(n);function i(){return{courts:[{name:"Корт №1",hours:[]},{name:"Корт №2",hours:[]}],date:a()().format("YYYY-MM-D"),menu:!1,modal:!1,menu2:!1,selectedHours:[],reservationHours:[],dialog:!1,newReservation:{fio:"",code:""},hoursForTable:[]}}var u={name:"reservation.vue",mixins:[{data:function(){return{userId:0}},mounted:function(){this.userId=parseInt(localStorage.user_id)}}],data:function(){return i()},mounted:function(){this.getCourts()},watch:{courtsJSON:function(){var t=this;this.selectedHours=[],this.reservationHours=[],this.courts.map(function(e,s){e.hours.map(function(o,r){o.user_id===t.userId&&o.is_select&&t.selectedHours.push({court_name:e.name,hour:o.hour,court_key:s,hour_key:r}),o.user_id===t.userId&&o.is_reservation&&t.reservationHours.push({court_name:e.name,hour:o.hour,court_key:s,hour_key:r})})})},date:function(){this.getCourts()}},computed:{courtsJSON:function(){return JSON.stringify(this.courts)}},methods:{getCourts:function(){var t=this;r()({url:"/api/court/get",method:"GET",params:{date:this.date}}).then(function(e){t.courts=e.data.courts,t.hoursForTable=e.data.headers})},reservation:function(){var t=this;r()({url:"/api/court/reservation",method:"POST",data:{courts:this.courts,date:this.date,user_id:this.userId,fio:this.newReservation.fio,code:this.newReservation.code}}).then(function(e){t.getCourts(),t.dialog=!1,t.newReservation=i().newReservation})},selectHour:function(t,e){if(this.selectedHours.length>=2){var s=this.selectedHours[0],o=this.selectedHours[1];this.courts[s.court_key].hours[s.hour_key].user_id=null,this.courts[s.court_key].hours[s.hour_key].is_select=!1,this.courts[o.court_key].hours[o.hour_key].user_id=null,this.courts[o.court_key].hours[o.hour_key].is_select=!1}else this.courts[t].hours[e].user_id=this.userId,this.courts[t].hours[e].is_select=!this.courts[t].hours[e].is_select}}},c=s(2),l=Object(c.a)(u,function(){var t=this,e=t.$createElement,s=t._self._c||e;return s("v-card",{staticClass:"d-inline-block mx-auto vue__page__reservation w-100 d-flex justify-content-center",attrs:{shaped:""}},[s("v-app",[s("div",{staticClass:"row"},[s("div",{staticClass:"col-md-12 text-center"},[s("h6",[t._v("Запись на муниципальные теннисные корты")])]),t._v(" "),s("div",{staticClass:"col-md-4 pt-1 pb-0"}),t._v(" "),s("div",{staticClass:"col-md-4 pt-1 pb-0 d-flex justify-content-center date-picker-for-reservation"},[s("v-dialog",{ref:"dialog",attrs:{"return-value":t.date,persistent:"",width:"290px"},on:{"update:returnValue":function(e){t.date=e},"update:return-value":function(e){t.date=e}},scopedSlots:t._u([{key:"activator",fn:function(e){var o=e.on,r=e.attrs;return[s("v-text-field",t._g(t._b({attrs:{readonly:""},model:{value:t.date,callback:function(e){t.date=e},expression:"date"}},"v-text-field",r,!1),o))]}}]),model:{value:t.modal,callback:function(e){t.modal=e},expression:"modal"}},[t._v(" "),s("v-date-picker",{attrs:{"first-day-of-week":1,scrollable:""},model:{value:t.date,callback:function(e){t.date=e},expression:"date"}},[s("v-spacer"),t._v(" "),s("v-btn",{attrs:{text:"",color:"primary"},on:{click:function(e){t.modal=!1}}},[t._v("Отмена")]),t._v(" "),s("v-btn",{attrs:{text:"",color:"primary"},on:{click:function(e){return t.$refs.dialog.save(t.date)}}},[t._v("Ок")])],1)],1)],1),t._v(" "),s("div",{staticClass:"col-md-4 pt-1 pb-0"}),t._v(" "),s("div",{staticClass:"col-md-4 pt-1 pb-0"}),t._v(" "),s("div",{staticClass:"col-md-4 pt-1 pb-0 d-flex justify-content-center"},[t.reservationHours.length>=2?s("v-alert",{attrs:{type:"warning"}},[t._v("\n          Нельзя забронировать больше 2-х часов в день!\n        ")]):s("v-btn",{attrs:{disabled:0===t.selectedHours.length,color:t.$blue},on:{click:function(e){t.dialog=!0}}},[t._v("\n          Забронировать\n        ")])],1),t._v(" "),s("div",{staticClass:"col-md-4 pt-1 pb-0"}),t._v(" "),s("div",{staticClass:"col-md-2"}),t._v(" "),s("div",{staticClass:"col-md-8 pt-1 pb-2"},[s("v-simple-table",{scopedSlots:t._u([{key:"default",fn:function(){return[s("thead",[s("tr",[s("th",{staticClass:"text-center"}),t._v(" "),t._l(t.hoursForTable,function(e){return s("th",{staticClass:"text-center"},[t._v("\n                "+t._s(e)+"\n              ")])})],2)]),t._v(" "),s("tbody",[t._l(t.courts,function(e,o){return[s("tr",[s("td",[t._v(t._s(e.name))]),t._v(" "),t._l(e.hours,function(r,n){return[s("v-menu",{attrs:{"nudge-bottom":"30","content-class":r.is_reservation?"":"box-shadow-none","open-on-hover":"",bottom:"",attach:"#tdWithHour"+e.id+r.hour},scopedSlots:t._u([{key:"activator",fn:function(a){var i=a.on,u=a.attrs;return[s("td",t._g(t._b({staticClass:"1",attrs:{id:"tdWithHour"+e.id+r.hour}},"td",u,!1),i),[s("v-btn",{staticClass:"button-for-reservation",attrs:{disabled:r.is_reservation,elevation:"0",color:r.is_select?t.$green:t.$blue,tile:"","x-small":""},on:{mousedown:function(e){return t.selectHour(o,n)}}})],1)]}}],null,!0)},[t._v(" "),r.is_reservation?s("v-list",[s("div",{staticClass:"p-1"},[t._v("\n                        Коммент: "+t._s(r.comment)),s("br"),t._v("\n                        Моб. телефон: "+t._s(r.phone_number)),s("br"),t._v("\n                        Дата бронирования: "+t._s(t.$moment(r.created_at).format("D.MM.YYYY hh:mm:ss"))+"\n                      ")])]):t._e()],1)]})],2)]})],2)]},proxy:!0}])})],1)])]),t._v(" "),s("v-dialog",{attrs:{persistent:"","max-width":"400"},model:{value:t.dialog,callback:function(e){t.dialog=e},expression:"dialog"}},[s("v-card",[s("v-card-text",[s("div",{staticClass:"row"},[s("div",{staticClass:"col-md-12"},[s("v-text-field",{attrs:{label:"Имя и фамилия",color:t.$blue,placeholder:"Обязательно"},model:{value:t.newReservation.fio,callback:function(e){t.$set(t.newReservation,"fio",e)},expression:"newReservation.fio"}})],1),t._v(" "),s("div",{staticClass:"col-md-12"},[s("v-text-field",{attrs:{label:"Код",color:t.$blue,placeholder:"Обязательно"},model:{value:t.newReservation.code,callback:function(e){t.$set(t.newReservation,"code",e)},expression:"newReservation.code"}})],1)])]),t._v(" "),s("v-card-actions",[s("v-spacer"),t._v(" "),s("v-btn",{attrs:{color:"green darken-1",text:""},on:{click:function(e){t.dialog=!1}}},[t._v("Отмена")]),t._v(" "),s("v-btn",{attrs:{color:"green darken-1",text:""},on:{click:function(e){return t.reservation()}}},[t._v("Забронировать")])],1)],1)],1)],1)},[],!1,null,null,null);e.default=l.exports}}]);