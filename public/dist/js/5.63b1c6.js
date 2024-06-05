(window.webpackJsonp=window.webpackJsonp||[]).push([[5],{30:function(e,t,i){"use strict";i.r(t);var n=i(1),a=i.n(n),l=i(5),s=i.n(l);function r(e,t,i,n,a,l,s){try{var r=e[l](s),o=r.value}catch(e){return void i(e)}r.done?t(o):Promise.resolve(o).then(n,a)}function o(e){return function(){var t=this,i=arguments;return new Promise((function(n,a){var l=e.apply(t,i);function s(e){r(l,n,a,s,o,"next",e)}function o(e){r(l,n,a,s,o,"throw",e)}s(void 0)}))}}var c,u,d,f,p,v,k,h,m={name:"FileLinks",data:function(){return{newFileLink:{file:null,name:""},fileLinks:[],editFileLink:{}}},mounted:function(){this.getFileLink()},methods:(c={openEditFileLink:function(e){this.editFileLink=e,this.editFileLink=e,this.$refs["edit-file"].show()},createFileLink:(h=o(a.a.mark((function e(){var t;return a.a.wrap((function(e){for(;;)switch(e.prev=e.next){case 0:return(t=new FormData).append("file",this.newFileLink.file),t.append("json",JSON.stringify(this.newFileLink)),e.next=5,s()({method:"POST",url:"/api/admin/file-links/store",data:t});case 5:e.sent.data,this.getFileLink();case 8:case"end":return e.stop()}}),e,this)}))),function(){return h.apply(this,arguments)}),storeFileLink:(k=o(a.a.mark((function e(){var t;return a.a.wrap((function(e){for(;;)switch(e.prev=e.next){case 0:return(t=new FormData).append("file",this.editFileLink.file),t.append("json",JSON.stringify(this.editFileLink)),e.next=5,s()({method:"POST",url:"/api/admin/file-links/store",data:t});case 5:e.sent.data,this.getFileLink();case 8:case"end":return e.stop()}}),e,this)}))),function(){return k.apply(this,arguments)}),getFileLink:(v=o(a.a.mark((function e(){var t,i;return a.a.wrap((function(e){for(;;)switch(e.prev=e.next){case 0:return e.next=2,s()({method:"get",url:"/api/admin/file-links"});case 2:t=e.sent,i=t.data,this.fileLinks=i;case 5:case"end":return e.stop()}}),e,this)}))),function(){return v.apply(this,arguments)}),deleteFileLink:(p=o(a.a.mark((function e(t){return a.a.wrap((function(e){for(;;)switch(e.prev=e.next){case 0:return e.next=2,s()({method:"post",url:"/api/admin/file-links/delete/"+t});case 2:e.sent.data,this.getFileLink();case 5:case"end":return e.stop()}}),e,this)}))),function(e){return p.apply(this,arguments)})},u="deleteFileLink",f=o(a.a.mark((function e(t){return a.a.wrap((function(e){for(;;)switch(e.prev=e.next){case 0:return e.next=2,s()({method:"post",url:"/api/admin/file-links/delete/"+t});case 2:e.sent.data,this.getFileLink();case 5:case"end":return e.stop()}}),e,this)}))),d=function(e){return f.apply(this,arguments)},u in c?Object.defineProperty(c,u,{value:d,enumerable:!0,configurable:!0,writable:!0}):c[u]=d,c)},L=i(2),F=Object(L.a)(m,(function(){var e=this,t=e.$createElement,i=e._self._c||t;return i("v-card",{staticClass:"mx-auto vue__page_file_links w-100",attrs:{shaped:""}},[i("div",{staticClass:"p-3"},[i("h4",{staticClass:"text-center"},[e._v("Новый файл")]),e._v(" "),i("div",{staticClass:"pl-5 pr-5"},[i("v-text-field",{attrs:{color:e.$blue,label:"Имя",name:"name"},model:{value:e.newFileLink.name,callback:function(t){e.$set(e.newFileLink,"name",t)},expression:"newFileLink.name"}})],1),e._v(" "),i("div",{staticClass:"pl-5 pr-5"},[i("v-file-input",{attrs:{color:e.$blue,label:"Файл",name:"file"},model:{value:e.newFileLink.file,callback:function(t){e.$set(e.newFileLink,"file",t)},expression:"newFileLink.file"}})],1),e._v(" "),i("div",{staticClass:"pl-5 pr-5"},[i("v-btn",{attrs:{color:e.$blue},on:{click:e.createFileLink}},[e._v("Создать")])],1)]),e._v(" "),i("div",{staticClass:"p-3 mt-2"},[i("v-simple-table",{scopedSlots:e._u([{key:"default",fn:function(){return[i("thead",[i("tr",[i("th",[e._v("Id")]),e._v(" "),i("th",[e._v("Имя")]),e._v(" "),i("th",[e._v("Файл")]),e._v(" "),i("th",[e._v("Управление")])])]),e._v(" "),e._l(e.fileLinks,(function(t){return i("tbody",{staticClass:"p-2"},[i("td",[e._v(e._s(t.id))]),e._v(" "),i("td",[e._v(e._s(t.name))]),e._v(" "),i("td",[i("a",{attrs:{target:"_blank",href:"/storage/file-links/"+t.file}},[e._v(e._s(t.name))])]),e._v(" "),i("td",[i("v-btn",{attrs:{color:e.$red},on:{click:function(i){return e.deleteFileLink(t.id)}}},[e._v("Удалить")]),e._v(" "),i("v-btn",{attrs:{color:e.$green},on:{click:function(i){return e.openEditFileLink(t)}}},[e._v("Редактировать")])],1)])}))]},proxy:!0}])})],1),e._v(" "),i("b-modal",{ref:"edit-file",attrs:{id:"edit-file",title:"Редактирование файла"},on:{ok:e.storeFileLink}},[i("div",{staticClass:"pl-5 pr-5"},[i("v-text-field",{attrs:{color:e.$blue,label:"Имя",name:"name"},model:{value:e.editFileLink.name,callback:function(t){e.$set(e.editFileLink,"name",t)},expression:"editFileLink.name"}})],1),e._v(" "),i("div",{staticClass:"pl-5 pr-5"},[i("v-file-input",{attrs:{color:e.$blue,label:"Файл",name:"file"},model:{value:e.editFileLink.file,callback:function(t){e.$set(e.editFileLink,"file",t)},expression:"editFileLink.file"}})],1)])],1)}),[],!1,null,"3b718f52",null);t.default=F.exports}}]);