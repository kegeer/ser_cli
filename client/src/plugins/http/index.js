import axios from 'axios'
import { apiUrl } from '../../config'
import interceptors from './interceptors'

export const http = axios.create({
  baseURL: apiUrl
})

export function setToken (token) {
  http.defaults.headers.common.Authorization = `Bearer ${token}`
}

export default function install (Vue, { store, router }) {
  interceptors(http, store, router)
  Object.defineProperty(Vue.prototype, '$http', {
    get () {
      return http
    }
  })
}
