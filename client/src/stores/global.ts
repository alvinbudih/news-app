import axios from 'axios'
import { defineStore } from 'pinia'
import { ref } from 'vue'

export const useGlobalStore = defineStore('global', () => {
  const baseUrl = ref('http://localhost:8000')

  const isLoading = ref(false)

  const request = axios.create({
    baseURL: `${baseUrl.value}/api`,
    headers: {
      Accept: 'application/json'
    }
  })

  const isLogin = ref(!!localStorage.getItem('access_token'))

  return { request, isLogin, baseUrl, isLoading }
})
