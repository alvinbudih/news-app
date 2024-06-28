import { defineStore } from 'pinia'
import { ref, type Ref } from 'vue'
import { useGlobalStore } from './global'

type News = {
  id: number
  title: string
  description: string
  image?: string
}

export const useNewsStore = defineStore('news', () => {
  const { request } = useGlobalStore()

  const items: Ref<Array<News>> = ref([])

  const item: Ref<News | null> = ref(null)

  async function getAllNews() {
    const { data } = await request({
      method: 'GET',
      url: '/news',
      headers: {
        Authorization: localStorage.getItem('access_token')
      }
    })

    items.value = data
  }

  async function getOneNews(id: string) {
    const { data } = await request({
      method: 'GET',
      url: `/news/${id}`,
      headers: {
        Authorization: localStorage.getItem('access_token')
      }
    })

    item.value = data
  }

  return { items, item, getAllNews, getOneNews }
})
