import { defineStore } from 'pinia'
import { useLogStore } from './log'
import { useNewsStore } from './news'

export const useDataStore = defineStore('data', () => {
  const { getLogs } = useLogStore()
  const { getAllNews } = useNewsStore()

  async function fetchAll() {
    try {
      await Promise.all([getLogs(), getAllNews()])
    } catch (error) {
      console.log(error)
    }
  }

  return { fetchAll }
})
