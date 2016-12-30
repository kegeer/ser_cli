// The Vue build version to load with the `import` command
// (runtime-only or standalone) has been set in webpack.base.conf with an alias.
import Vue from 'vue'
import Root from './Root'
import store from './store'
import router from './router'
import ElementUI from 'element-ui'
import 'element-ui/lib/theme-default/index.css'
import httpPlugin from './plugins/http'
import eventBus from './plugins/eventBus'
import BreadCrumb from './components/breadcrumb'
import './assets/scss/app.scss'
Vue.use(ElementUI)
Vue.use(httpPlugin, { store, router })
Vue.use(eventBus)
Vue.component('breadcrumb', BreadCrumb)
/* eslint-disable no-new */
new Vue({
  store,
  router,
  el: '#app',
  render: h => h(Root)
})
