<script setup lang="ts">
import Card from '@/components/Card.vue'
import router from '@/router'
import { useDataStore } from '@/stores/data'
import { useGlobalStore } from '@/stores/global'
import { useNewsStore } from '@/stores/news'
import { AxiosError } from 'axios'
import { storeToRefs } from 'pinia'
import swal from 'sweetalert'
import { onBeforeMount, reactive, ref } from 'vue'
import { useRoute } from 'vue-router'

type News = {
  title: string
  description: string
  image: any
}

interface TargetValue extends EventTarget {
  files: any[]
}

const {
  params: { id }
} = useRoute()

const isEdit = ref(!!id)

const global = useGlobalStore()
const newsStore = useNewsStore()
const { fetchAll } = useDataStore()

const { request } = global
const { getOneNews } = newsStore

const { isLoading } = storeToRefs(global)
const { item } = storeToRefs(newsStore)

const form: News = reactive({
  title: '',
  description: '',
  image: null
})

function fileHandler(e: Event) {
  form.image = (e.target as TargetValue).files[0]
}

onBeforeMount(async () => {
  if (isEdit.value) {
    isLoading.value = true
    await getOneNews(id as string)

    form.title = item.value!.title
    form.description = item.value!.description

    isLoading.value = false
  }
})

async function createNews() {
  isLoading.value = true

  try {
    const formData = new FormData()
    formData.append('title', form.title)
    formData.append('description', form.description)
    if (form.image) {
    }

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

async function updateNews() {
  isLoading.value = true

  try {
    const formData = new FormData()

    formData.append('title', form.title)
    formData.append('description', form.description)
    if (form.image) {
      formData.append('image', form.image)
    }
    formData.append('_method', 'PUT')

    await request({
      method: 'POST',
      url: `/news/${id}`,
      data: formData,
      headers: {
        Authorization: localStorage.getItem('access_token')
      }
    })

    swal('Success', 'News updated successfully', 'success')
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
  <h1 class="text-3xl font-bold">{{ isEdit ? 'Edit' : 'Create' }} News</h1>

  <Card class="p-8 my-5">
    <form
      @submit.prevent="isEdit ? updateNews() : createNews()"
      autocomplete="off"
      enctype="multipart/form-data"
    >
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

      <div class="flex justify-end gap-2">
        <RouterLink to="/news" class="bg-amber-500 text-white p-2 rounded hover:bg-amber-700">
          Cancel
        </RouterLink>
        <button type="submit" class="bg-indigo-500 text-white p-2 rounded hover:bg-indigo-700">
          Submit
        </button>
      </div>
    </form>
  </Card>
</template>
