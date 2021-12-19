import Vue from 'vue'
import App from './App.vue'
import Router from './router'
import Request from './request'
import Auth from './auth'
import Element from 'element-ui'
import lang from 'element-ui/lib/locale/lang/en'
import './styles/element-variables.scss'
import './styles/base.scss'


Vue.use(Element, {  
  locale: lang,
});

Vue.config.productionTip = false

Vue.prototype.$request = Request
Vue.prototype.$auth = Auth
Vue.prototype.$bus = new Vue()

new Vue({
  el: '#app',
  router: Router,
  render: h => h(App)
})
