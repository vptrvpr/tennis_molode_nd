(window.webpackJsonp=window.webpackJsonp||[]).push([[13],{29:function(t,e,s){"use strict";s.r(e);var a=s(1),r=s.n(a),i=s(5),n=s.n(i),o=s(0),c=s.n(o),l=s(8);function u(t,e){return function(t){if(Array.isArray(t))return t}(t)||function(t,e){var s=[],a=!0,r=!1,i=void 0;try{for(var n,o=t[Symbol.iterator]();!(a=(n=o.next()).done)&&(s.push(n.value),!e||s.length!==e);a=!0);}catch(t){r=!0,i=t}finally{try{a||null==o.return||o.return()}finally{if(r)throw i}}return s}(t,e)||function(){throw new TypeError("Invalid attempt to destructure non-iterable instance")}()}function d(t,e,s,a,r,i,n){try{var o=t[i](n),c=o.value}catch(t){return void s(t)}o.done?e(c):Promise.resolve(c).then(a,r)}var v,h,f={name:"reservation.vue",mixins:[{computed:Object(l.b)({authUser:"auth/user"})}],data:function(){return{weeks:[],date:c()().format("YYYY-MM-D"),weeksPicker:{1:c()().startOf("week"),2:c()().endOf("week")},menu:!1,modal:!1,menu2:!1,selectedHours:[],reservationHours:[],dialogCancelReservation:!1,cancelReservationId:null,dialog:!1,newReservation:{fio:"",code:""},headersTable:[],hours:[],fileLinks:[],showCamers:!1}},mounted:function(){this.getCourts(),this.getFileLink()},methods:{getFileLink:(v=r.a.mark((function t(){var e,s;return r.a.wrap((function(t){for(;;)switch(t.prev=t.next){case 0:return t.next=2,n()({method:"get",url:"/api/admin/file-links"});case 2:e=t.sent,s=e.data,this.fileLinks=s;case 5:case"end":return t.stop()}}),t,this)})),h=function(){var t=this,e=arguments;return new Promise((function(s,a){var r=v.apply(t,e);function i(t){d(r,s,a,i,n,"next",t)}function n(t){d(r,s,a,i,n,"throw",t)}i(void 0)}))},function(){return h.apply(this,arguments)}),openDialogCancelReservation:function(t){this.dialogCancelReservation=!0,this.cancelReservationId=t},cancelReservation:function(){var t=this;n()({method:"DELETE",url:"/api/court/reservation/"+this.cancelReservationId}).then((function(e){t.$notif(e.data),t.getCourts(),t.dialogCancelReservation=!1,t.$store.dispatch("auth/fetchUser")}))},changeWeek:function(t){"sub"===t?this.weeksPicker={1:this.weeksPicker[1].subtract(7,"days"),2:this.weeksPicker[2].subtract(7,"days")}:"add"===t&&(this.weeksPicker={1:this.weeksPicker[1].add(7,"days"),2:this.weeksPicker[2].add(7,"days")})},getCourts:function(){var t=this;n()({url:"/api/court/get",method:"GET",params:{date:[this.weeksPicker[1].format("YYYY-MM-DD"),this.weeksPicker[2].format("YYYY-MM-DD")]}}).then((function(e){t.weeks=e.data.weeks,t.headersTable=e.data.headers,t.hours=e.data.hours}))},reservation:function(){var t=this;n()({url:"/api/court/reservation",method:"POST",data:{hours:this.hours}}).then((function(e){t.$notif(e.data),t.getCourts(),t.dialog=!1,t.$store.dispatch("auth/fetchUser")})).catch((function(e){t.dialog=!1,t.$store.dispatch("auth/fetchUser"),443==e.response.status&&t.getCourts()}))},selectHour:function(t,e){if(this.selectedHours.length>=2&&!this.authUser.checkRole(1)){var s=this.selectedHours[0],a=this.selectedHours[1];this.hours[s.hour_key][s.key].user_id=null,this.hours[s.hour_key][s.key].is_select=!1,this.hours[a.hour_key][a.key].user_id=null,this.hours[a.hour_key][a.key].is_select=!1}else this.hours[t][e].user_id=this.authUser.id,this.hours[t][e].is_select=!this.hours[t][e].is_select},getHours:function(t){return"".concat(t<10?0+t:t,"-").concat(parseInt(t)+1)}},watch:{hoursJSON:function(){var t=this;this.selectedHours=[],this.reservationHours=[];for(var e=function(){var e=u(a[s],2),r=e[0];e[1].map((function(e,s){e.user_id===t.authUser.id&&e.is_select&&t.selectedHours.push({hour_key:r,hour:e.hour,key:s}),e.user_id===t.authUser.id&&e.is_reservation&&t.reservationHours.push({hour_key:r,hour:e.hour,key:s})}))},s=0,a=Object.entries(this.hours);s<a.length;s++)e()},weekForInput:function(){this.getCourts()}},computed:{hoursJSON:function(){return JSON.stringify(this.hours)},weekForInput:function(){return"".concat(this.weeksPicker[1].format("DD.MM.YYYY")," - ").concat(this.weeksPicker[2].format("DD.MM.YYYY"))}}},_=s(2),p=Object(_.a)(f,(function(){var t=this,e=t.$createElement,s=t._self._c||e;return s("div",[s("v-card",{staticClass:"d-inline-block mx-auto vue__page__reservation w-100 d-flex justify-content-center",attrs:{shaped:""}},[s("v-app",[s("div",{staticClass:"row"},[s("div",{staticClass:"col-md-12 text-center"},[s("h6",[t._v("Запись на муниципальные теннисные корты")])]),t._v(" "),s("div",{staticStyle:{display:"flex","justify-content":"center",width:"100%"}},t._l(t.fileLinks,(function(e){return s("v-btn",{staticClass:"mr-2",attrs:{color:t.$blue,target:"_blank",small:"",href:"/storage/file-links/"+e.file}},[t._v("\n            "+t._s(e.name)+"\n          ")])})),1),t._v(" "),s("div",{staticClass:"col-md-12 d-flex justify-content-center"},[s("div",{staticClass:"d-flex"},[s("v-btn",{staticClass:"btn-reservation-info",attrs:{elevation:"0",color:t.$red,tile:"","x-small":""}},[s("i",{staticClass:"fa-solid fa-ban",staticStyle:{"font-size":"17px"}})]),t._v(" "),s("h6",{staticClass:"ml-1 mt-1"},[t._v("- Отменить")])],1),t._v(" "),s("div",{staticClass:"d-flex ml-2"},[s("v-btn",{staticClass:"btn-reservation-info",attrs:{elevation:"0",disabled:"",color:t.$red,tile:"","x-small":""}}),t._v(" "),s("h6",{staticClass:"ml-1 mt-1"},[t._v("- Занято")])],1),t._v(" "),s("div",{staticClass:"d-flex ml-2"},[s("v-btn",{staticClass:"btn-reservation-info",attrs:{elevation:"0",color:t.$blue,tile:"","x-small":""}}),t._v(" "),s("h6",{staticClass:"ml-1 mt-1"},[t._v("- Свободно")])],1)]),t._v(" "),s("div",{staticClass:"col-md-4 pt-1 pb-0 d-flex justify-content-center"}),t._v(" "),s("div",{staticClass:"col-md-4 pt-1 pb-0 d-flex justify-content-center date-picker-for-reservation"},[t.authUser.checkRole(1)?s("v-btn",{staticClass:"mt-4",attrs:{fab:"",text:"",color:t.$blue,"x-small":""},on:{click:function(e){return t.changeWeek("sub")}}},[s("i",{staticClass:"fas fa-chevron-left",staticStyle:{"font-size":"19px"}})]):t._e(),t._v(" "),s("v-text-field",{staticClass:"input-week-picker",attrs:{"hide-details":"",disabled:"",color:t.$blue},model:{value:t.weekForInput,callback:function(e){t.weekForInput=e},expression:"weekForInput"}}),t._v(" "),t.authUser.checkRole(1)?s("v-btn",{staticClass:"mt-4",attrs:{fab:"",text:"",color:t.$blue,"x-small":""},on:{click:function(e){return t.changeWeek("add")}}},[s("i",{staticClass:"fas fa-chevron-right",staticStyle:{"font-size":"19px"}})]):t._e()],1),t._v(" "),s("div",{staticClass:"col-md-4 pt-1 pb-0"}),t._v(" "),s("div",{staticClass:"col-md-3 pt-1 pb-0"}),t._v(" "),s("div",{staticClass:"col-md-6 mt-1 pt-1 pb-0 d-flex justify-content-center"},[t.authUser.id&&t.authUser.is_active?s("v-btn",{attrs:{disabled:0===t.selectedHours.length,color:t.$blue},on:{click:function(e){t.dialog=!0}}},[t._v("\n            Забронировать\n          ")]):t.authUser.id&&!t.authUser.is_active?s("v-alert",{attrs:{type:"warning"}},[t._v("\n            Необходимо заполнить заявление у председателя, подробно в разделе\n            "),t._l(t.fileLinks,(function(e){return"Новым участникам"===e.name?s("b-link",{attrs:{small:"",href:"/storage/file-links/"+e.file}},[t._v("\n              «Новым участникам»\n            ")]):t._e()})),t._v("\n            .\n          ")],2):s("v-btn",{attrs:{color:t.$green,href:"/login"}},[t._v("\n            ВОЙТИ\n          ")])],1),t._v(" "),s("div",{staticClass:"col-md-3 pt-1 pb-0"}),t._v(" "),s("div",{staticClass:"col-md-2"}),t._v(" "),s("div",{staticClass:"col-md-8 pt-1 pb-2"},[s("v-simple-table",{attrs:{"fixed-header":""},scopedSlots:t._u([{key:"default",fn:function(){return[s("thead",[s("tr",[s("th",{staticClass:"text-center",attrs:{colspan:"1"}}),t._v(" "),t._l(t.headersTable,(function(e){return s("th",{staticClass:"text-center",attrs:{colspan:"2"}},[t._v("\n                  "+t._s(e.name)+"\n                ")])}))],2),t._v(" "),s("tr",[s("th",{staticClass:"text-center",attrs:{colspan:"1"}}),t._v(" "),t._l(t.headersTable,(function(e){return t._l(e.courts,(function(e){return s("th",{staticClass:"pl-1 pr-1 text-center"},[t._v("\n                    "+t._s(e.name)+"\n                  ")])}))}))],2)]),t._v(" "),s("tbody",t._l(t.hours,(function(e,a){return s("tr",[s("td",{staticStyle:{width:"36px","white-space":"nowrap"}},[t._v(t._s(t.getHours(a)))]),t._v(" "),t._l(e,(function(e,r){return[void 0!==e.is_reservation?[s("v-menu",{attrs:{"nudge-left":"0","nudge-top":"40","content-class":e.is_reservation?"":"box-shadow-none","open-on-hover":"",left:"",attach:"#tdWithHour"+a+e.hour},scopedSlots:t._u([{key:"activator",fn:function(i){var n=i.on,o=i.attrs;return[t.authUser.id&&t.authUser.is_active?e.time_has_passed&&!t.authUser.checkRole(1)?s("td",t._g(t._b({class:(r+1)%2==0?"pr-2":"pl-2",attrs:{id:"tdWithHour"+a+e.hour}},"td",o,!1),n),[s("v-btn",{staticClass:"button-for-reservation",style:{opacity:e.is_reservation&&!e.user_id?.5:1},attrs:{disabled:!0,elevation:"0",color:e.is_select?t.$green:t.$blue,tile:"","x-small":""}})],1):e.is_reservation&&e.user_id===t.authUser.id||e.is_reservation&&e.user_id&&t.authUser.checkRole(1)?s("td",t._g(t._b({class:(r+1)%2==0?"pr-2":"pl-2",attrs:{id:"tdWithHour"+a+e.hour}},"td",o,!1),n),[s("v-btn",{staticClass:"button-for-reservation",attrs:{elevation:"0",disabled:e.minutes_left&&!t.authUser.checkRole(1),color:t.$red,tile:"","x-small":""},on:{click:function(s){return t.openDialogCancelReservation(e.id)}}},[s("i",{staticClass:"fa-solid fa-ban",staticStyle:{"font-size":"17px"}})])],1):s("td",t._g(t._b({class:(r+1)%2==0?"pr-2":"pl-2",attrs:{id:"tdWithHour"+a+e.hour}},"td",o,!1),n),[s("v-btn",{staticClass:"button-for-reservation",style:{opacity:e.is_reservation&&!e.user_id?.5:1},attrs:{disabled:e.is_reservation,elevation:"0",color:e.is_select?t.$green:t.$blue,tile:"","x-small":""},on:{click:function(e){return t.selectHour(a,r)}}},[e.is_reservation&&e.user_id?s("i",{staticClass:"fa-solid fa-check",staticStyle:{"font-size":"17px"}}):t._e()])],1):s("td",t._g(t._b({class:(r+1)%2==0?"pr-2":"pl-2",attrs:{id:e.is_reservation&&e.user_id?"tdWithHour"+a+e.hour:""}},"td",o,!1),n),[s("v-btn",{staticClass:"button-for-reservation",style:{opacity:e.is_reservation&&!e.user_id?.5:.7},attrs:{disabled:!0,elevation:"0",color:e.is_select?t.$green:t.$blue,tile:"","x-small":""}},[e.is_reservation&&e.user_id?s("i",{staticClass:"fa-solid fa-check",staticStyle:{"font-size":"17px"}}):t._e()])],1)]}}],null,!0)},[t._v(" "),e.is_reservation&&e.user_id?s("v-list",[s("div",{staticClass:"p-1"},[t._v("\n                          "+t._s(e.user?e.user.name:"")),s("br"),t._v(" "),t.authUser.id&&t.authUser.checkRole(1)?[t._v("\n                            "+t._s(t.$moment(e.created_at).format("DD.MM.YYYY hh:mm:ss"))+"\n                          ")]:t._e()],2)]):t._e()],1)]:[s("td")]]}))],2)})),0)]},proxy:!0}])})],1),t._v(" "),s("div",{staticClass:"col-md-12 p-3 row"},[s("div",{staticClass:"col-md-12 d-flex justify-content-center"},[s("v-btn",{attrs:{color:t.$blue},on:{click:function(e){t.showCamers=!t.showCamers}}},[t._v("\n              Прямая трансляция\n            ")])],1),t._v(" "),t.showCamers?[s("div",{staticClass:"col-md-6 col-sm-12 justify-content-center",staticStyle:{display:"grid"}},[s("h5",{staticClass:"text-center"},[t._v("Корт 1")]),t._v(" "),s("iframe",{attrs:{src:"https://cactus.tv:444/cam24/embed.html?&token=tennis",width:"468",height:"350",align:"left"}},[t._v("\n                Ваш браузер не поддерживает плавающие фреймы!\n              ")])]),t._v(" "),s("div",{staticClass:"col-md-6 col-sm-12 justify-content-center",staticStyle:{display:"grid"}},[s("h5",{staticClass:"text-center"},[t._v("Корт 2")]),t._v(" "),s("iframe",{attrs:{src:"https://cactus.tv:444/cam25/embed.html?&token=tennis",width:"468",height:"350",align:"left"}},[t._v("\n                Ваш браузер не поддерживает плавающие фреймы!\n              ")])])]:t._e()],2)])]),t._v(" "),s("v-dialog",{attrs:{persistent:"","max-width":"300"},model:{value:t.dialog,callback:function(e){t.dialog=e},expression:"dialog"}},[s("v-card",[s("v-card-title",{staticClass:"text-center justify-content-center"},[t._v("Вы уверены ,что хотите"),s("br"),t._v(" забронировать?\n        ")]),t._v(" "),s("v-card-actions",[s("v-btn",{attrs:{color:"green darken-1",large:"",text:""},on:{click:function(e){t.dialog=!1}}},[t._v("Нет")]),t._v(" "),s("v-spacer"),t._v(" "),s("v-btn",{attrs:{color:"green darken-1",large:"",text:""},on:{click:function(e){return t.reservation()}}},[t._v("Да")])],1)],1)],1),t._v(" "),s("v-dialog",{attrs:{persistent:"","max-width":"300"},model:{value:t.dialogCancelReservation,callback:function(e){t.dialogCancelReservation=e},expression:"dialogCancelReservation"}},[s("v-card",[s("v-card-title",{staticClass:"text-center justify-content-center"},[t._v("\n          Вы уверены ,что хотите"),s("br"),t._v(" отменить бронь?\n        ")]),t._v(" "),s("v-card-actions",[s("v-btn",{attrs:{color:"green darken-1",large:"",text:""},on:{click:function(e){t.dialogCancelReservation=!1}}},[t._v("Нет")]),t._v(" "),s("v-spacer"),t._v(" "),s("v-btn",{attrs:{color:"green darken-1",large:"",text:""},on:{click:function(e){return t.cancelReservation()}}},[t._v("Да")])],1)],1)],1)],1)],1)}),[],!1,null,null,null);e.default=p.exports}}]);