(window.webpackJsonp=window.webpackJsonp||[]).push([[5],{28:function(t,e,s){"use strict";s.r(e);var n=s(8),a=s.n(n);var i={name:"users",middleware:["admin","auth"],data:function(){return{users:[]}},mounted:function(){this.getUsers()},methods:{getUsers:function(){var t=this;a()({method:"GET",url:"/api/admin/user"}).then(function(e){t.users=e.data})},setActive:function(t){var e=this;a()({method:"POST",url:"/api/admin/user/active/"+t}).then(function(t){e.getUsers(),e.$notif(t)})}}},r=s(2),u=Object(r.a)(i,function(){var t=this,e=t.$createElement,s=t._self._c||e;return s("v-card",{staticClass:" mx-auto vue__page_admin_users w-100",attrs:{shaped:""}},[s("v-simple-table",{scopedSlots:t._u([{key:"default",fn:function(){return[s("thead",[s("tr",[s("th",[t._v("Id")]),t._v(" "),s("th",[t._v("Имя")]),t._v(" "),s("th",[t._v("Активный")]),t._v(" "),s("th",[t._v("Управление")])])]),t._v(" "),t._l(t.users,function(e){return s("tbody",[s("tr",[s("td",[t._v(t._s(e.id))]),t._v(" "),s("td",[t._v(t._s(e.name))]),t._v(" "),s("td",[s("v-chip",{staticClass:"ma-2",attrs:{color:e.is_active?t.$green:t.$blue}},[t._v("\n            "+t._s(e.is_active?"Да":"Нет")+"\n          ")])],1),t._v(" "),s("td",[s("v-btn",{attrs:{color:t.$green,fab:"","x-small":""},on:{click:function(s){return t.setActive(e.id)}}},[s("i",{staticClass:"fab fa-creative-commons-sa",staticStyle:{"font-size":"17px"}})])],1)])])})]},proxy:!0}])})],1)},[],!1,null,"1bfe4aab",null);e.default=u.exports}}]);