import { defineStore } from 'pinia'
import { ref, type Ref } from 'vue'
import { useGlobalStore } from './global'

type Log = {
  id: number
  user: {
    id: number
    name: string
    email: string
  }
  description: string
  created_at: Date
}

export const useLogStore = defineStore('log', () => {
  const { request } = useGlobalStore()

  const logs: Ref<Array<Log>> = ref([])

  async function getLogs() {
    const { data } = await request({
      method: 'GET',
      url: '/logs',
      headers: {
        Authorization: localStorage.getItem('access_token')
      }
    })

    logs.value = data
  }

  return { logs, getLogs }
})
