<script setup lang="ts">
import Card from '@/components/Card.vue'
import router from '@/router'
import { useDataStore } from '@/stores/data'
import { useGlobalStore } from '@/stores/global'
import { AxiosError } from 'axios'
import { storeToRefs } from 'pinia'
import swal from 'sweetalert'
import { reactive } from 'vue'

type News = {
  title: string
  description: string
  image: any
}

interface TargetValue extends EventTarget {
  files: any[]
}

const global = useGlobalStore()
const { fetchAll } = useDataStore()

const { request } = global

const { isLoading } = storeToRefs(global)

const form: News = reactive({
  title: '',
  description: '',
  image: null
})

function fileHandler(e: Event) {
  form.image = (e.target as TargetValue).files[0]
}

async function createNews() {
  isLoading.value = true

  try {
    const formData = new FormData()
    formData.append('title', form.title)
    formData.append('description', form.description)
    formData.append('image', form.image)

    await request({
      method: 'POST',
      url: '/news',
      data: formData,
      headers: {
        Authorization: localStorage.getItem('access_token')
      }
    })

    swal('Success', 'News created successfully', 'success')
    await fetchAll()
    isLoading.value = false
    router.push('/news')
  } catch (error) {
    if (error instanceof AxiosError) {
      swal('Failed', error.response?.data.message, 'error')
    }

    console.log(error)
    isLoading.value = false
  }
}
</script>

<template>
  <h1 class="text-3xl font-bold">Create News</h1>

  <Card class="p-8 my-5">
    <form @submit.prevent="createNews" autocomplete="off" enctype="multipart/form-data">
      <div class="flex flex-col mb-5">
        <div class="flex flex-col mb-3">
          <label for="title">Title</label>
          <input
            v-model="form.title"
            class="focus:outline-none focus:ring focus:ring-violet-300 rounded border h-8"
            type="text"
            name="title"
            id="title"
          />
        </div>
        <div class="flex flex-col mb-3">
          <label for="description">Description</label>
          <textarea
            v-model="form.description"
            class="focus:outline-none focus:ring focus:ring-violet-300 rounded border h-20"
            name="description"
            id="description"
          ></textarea>
        </div>
        <div class="flex flex-col mb-3">
          <label for="image">Image</label>
          <input
            @change="fileHandler"
            class="focus:outline-none focus:ring focus:ring-violet-300 rounded border h-8"
            type="file"
            name="image"
            id="image"
          />
        </div>
      </div>

      <div class="flex justify-end">
        <button type="submit" class="bg-indigo-500 text-white p-2 rounded hover:bg-indigo-700">
          Submit
        </button>
      </div>
    </form>
  </Card>
</template>
