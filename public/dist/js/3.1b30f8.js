(window.webpackJsonp=window.webpackJsonp||[]).push([[3],{20:function(t,e,n){"use strict";var r=n(1),o=n.n(r);function i(t,e,n){return e in t?Object.defineProperty(t,e,{value:n,enumerable:!0,configurable:!0,writable:!0}):t[e]=n,t}function s(t){return(s="function"==typeof Symbol&&"symbol"==typeof Symbol.iterator?function(t){return typeof t}:function(t){return t&&"function"==typeof Symbol&&t.constructor===Symbol&&t!==Symbol.prototype?"symbol":typeof t})(t)}function a(t,e,n,r,o,i,s){try{var a=t[i](s),u=a.value}catch(t){return void n(t)}a.done?e(u):Promise.resolve(u).then(r,o)}function u(t,e){var n=arguments.length>2&&void 0!==arguments[2]?arguments[2]:{};"object"===s(t)&&(n=t,t=""),n=function(t){for(var e=1;e<arguments.length;e++){var n=null!=arguments[e]?arguments[e]:{},r=Object.keys(n);"function"==typeof Object.getOwnPropertySymbols&&(r=r.concat(Object.getOwnPropertySymbols(n).filter(function(t){return Object.getOwnPropertyDescriptor(n,t).enumerable}))),r.forEach(function(e){i(t,e,n[e])})}return t}({url:t,title:e,width:600,height:720},n);var r=void 0!==window.screenLeft?window.screenLeft:window.screen.left,o=void 0!==window.screenTop?window.screenTop:window.screen.top,a=window.innerWidth||document.documentElement.clientWidth||window.screen.width,u=window.innerHeight||document.documentElement.clientHeight||window.screen.height;n.left=a/2-n.width/2+r,n.top=u/2-n.height/2+o;var c=Object.keys(n).reduce(function(t,e){return t.push("".concat(e,"=").concat(n[e])),t},[]).join(","),l=window.open(t,e,c);return window.focus&&l.focus(),l}var c={name:"LoginWithGithub",computed:{githubAuth:function(){return window.config.githubAuth},url:function(){return"/api/oauth/github"}},mounted:function(){window.addEventListener("message",this.onMessage,!1)},beforeDestroy:function(){window.removeEventListener("message",this.onMessage)},methods:{login:function(){var t,e=(t=o.a.mark(function t(){var e,n;return o.a.wrap(function(t){for(;;)switch(t.prev=t.next){case 0:return e=u("",this.$t("login")),t.next=3,this.$store.dispatch("auth/fetchOauthUrl",{provider:"github"});case 3:n=t.sent,e.location.href=n;case 5:case"end":return t.stop()}},t,this)}),function(){var e=this,n=arguments;return new Promise(function(r,o){var i=t.apply(e,n);function s(t){a(i,r,o,s,u,"next",t)}function u(t){a(i,r,o,s,u,"throw",t)}s(void 0)})});return function(){return e.apply(this,arguments)}}(),onMessage:function(t){t.origin===window.origin&&t.data.token&&(this.$store.dispatch("auth/saveToken",{token:t.data.token}),this.$router.push({name:"home"}))}}},l=n(2),f=Object(l.a)(c,function(){var t=this.$createElement,e=this._self._c||t;return this.githubAuth?e("button",{staticClass:"btn btn-dark ml-auto",attrs:{type:"button"},on:{click:this.login}},[this._v("\n  "+this._s(this.$t("login_with"))+"\n  "),e("fa",{attrs:{icon:["fab","github"]}})],1):this._e()},[],!1,null,null,null);e.a=f.exports},29:function(t,e,n){"use strict";n.r(e);var r=n(1),o=n.n(r),i=n(6),s=n.n(i);function a(t,e,n,r,o,i,s){try{var a=t[i](s),u=a.value}catch(t){return void n(t)}a.done?e(u):Promise.resolve(u).then(r,o)}var u={middleware:"guest",components:{LoginWithGithub:n(20).a},metaInfo:function(){return{title:this.$t("login")}},data:function(){return{form:new s.a({email:"",password:""}),remember:!1}},methods:{login:function(){var t,e=(t=o.a.mark(function t(){var e,n;return o.a.wrap(function(t){for(;;)switch(t.prev=t.next){case 0:return t.next=2,this.form.post("/api/login");case 2:return e=t.sent,n=e.data,this.$store.dispatch("auth/saveToken",{token:n.token,remember:this.remember}),t.next=7,this.$store.dispatch("auth/fetchUser");case 7:this.$router.push({name:"home"});case 8:case"end":return t.stop()}},t,this)}),function(){var e=this,n=arguments;return new Promise(function(r,o){var i=t.apply(e,n);function s(t){a(i,r,o,s,u,"next",t)}function u(t){a(i,r,o,s,u,"throw",t)}s(void 0)})});return function(){return e.apply(this,arguments)}}()}},c=n(2),l=Object(c.a)(u,function(){var t=this,e=t.$createElement,n=t._self._c||e;return n("div",{staticClass:"row"},[n("div",{staticClass:"col-lg-6 m-auto"},[n("card",{attrs:{title:"Войти"}},[n("form",{on:{submit:function(e){return e.preventDefault(),t.login(e)},keydown:function(e){return t.form.onKeydown(e)}}},[n("div",{staticClass:"pl-5 pr-5"},[n("v-text-field",{attrs:{color:t.$blue,label:"E-mail",name:"email",error:void 0!==t.form.errors.errors.email,"error-messages":t.form.errors.errors.email},model:{value:t.form.email,callback:function(e){t.$set(t.form,"email",e)},expression:"form.email"}})],1),t._v(" "),n("div",{staticClass:"pl-5 pr-5"},[n("v-text-field",{attrs:{color:t.$blue,label:"Пароль",type:"password",name:"password",error:void 0!==t.form.errors.errors.password,"error-messages":t.form.errors.errors.password},model:{value:t.form.password,callback:function(e){t.$set(t.form,"password",e)},expression:"form.password"}})],1),t._v(" "),n("div",{staticClass:"form-group row mb-0"},[n("div",{staticClass:"col-md-12 pl-5 pr-5 d-flex"},[n("v-checkbox",{attrs:{name:"remember",color:t.$blue,label:"Запомнить меня"},model:{value:t.remember,callback:function(e){t.remember=e},expression:"remember"}}),t._v(" "),n("router-link",{staticClass:"small ml-auto my-auto",attrs:{to:{name:"password.request"}}},[t._v("\n              "+t._s(t.$t("forgot_password"))+"\n            ")])],1)]),t._v(" "),n("div",{staticClass:"form-group row"},[n("div",{staticClass:"col-md-12 d-flex justify-content-center"},[n("v-btn",{attrs:{color:t.$blue,type:"submit",loading:t.form.busy}},[t._v("Войти")])],1)])])])],1)])},[],!1,null,null,null);e.default=l.exports}}]);