<script setup lang="ts">
import Card from '@/components/Card.vue'
import { useDataStore } from '@/stores/data'
import { useGlobalStore } from '@/stores/global'
import { useNewsStore } from '@/stores/news'
import { AxiosError } from 'axios'
import { storeToRefs } from 'pinia'
import swal from 'sweetalert'
import { RouterLink } from 'vue-router'

const global = useGlobalStore()
const newsStore = useNewsStore()
const { fetchAll } = useDataStore()

const { request } = global

const { baseUrl, isLoading } = storeToRefs(global)
const { items } = storeToRefs(newsStore)

async function deleteImage(id: number) {
  isLoading.value = true

  try {
    await request({
      method: 'DELETE',
      url: `/news/${id}`,
      headers: {
        Authorization: localStorage.getItem('access_token')
      }
    })

    swal('Success', 'News deleted successfully', 'success')
    await fetchAll()
  } catch (error) {
    if (error instanceof AxiosError) {
      swal('Failed', error.response?.data.message, 'error')
    }

    console.log(error)
  } finally {
    isLoading.value = false
  }
}
</script>

<template>
  <h1 class="text-3xl font-bold">Logs</h1>

  <div class="flex justify-end">
    <RouterLink to="/news/create" class="bg-indigo-500 text-white p-1 rounded hover:bg-indigo-700"
      >Create</RouterLink
    >
  </div>
  <Card class="p-5 my-5">
    <table class="table-auto w-full text-center">
      <thead class="text-slate-700">
        <tr>
          <th class="p-4">No</th>
          <th class="p-4">Image</th>
          <th class="p-4">Title</th>
          <th class="p-4">Description</th>
          <th class="p-4">Actions</th>
        </tr>
      </thead>
      <tbody class="text-slate-500">
        <tr v-for="(item, i) in items" :key="item.id">
          <td class="p-4">{{ i + 1 }}</td>
          <td class="p-4">
            <img :src="baseUrl + '/storage/' + item.image" :alt="item.title" width="200" />
          </td>
          <td class="p-4">{{ item.title }}</td>
          <td class="p-4">{{ item.description }}</td>
          <td class="p-4">
            <RouterLink
              :to="{ name: 'newsEdit', params: { id: item.id } }"
              class="bg-amber-500 text-white p-1 rounded hover:bg-amber-700 mr-1"
              >Edit</RouterLink
            >
            <a
              @click.prevent="deleteImage(item.id)"
              href=""
              class="bg-red-500 text-white p-1 rounded hover:bg-red-700"
              >Delete</a
            >
          </td>
        </tr>
      </tbody>
    </table>
  </Card>
</template>
