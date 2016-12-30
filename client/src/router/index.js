import Vue from 'vue'
import VueRouter from 'vue-router'
import { routes as app } from '../app'

Vue.use(VueRouter)
const routes = [...app]
const router = new VueRouter({
  routes,
  linkActiveClass: 'active',
  mode: 'history'
})

export default router
