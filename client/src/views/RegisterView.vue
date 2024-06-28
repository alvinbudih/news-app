<script setup lang="ts">
import Card from '@/components/Card.vue'
import Loader from '@/components/Loader.vue'
import router from '@/router'
import { useGlobalStore } from '@/stores/global'
import { AxiosError } from 'axios'
import { storeToRefs } from 'pinia'
import swal from 'sweetalert'
import { reactive, ref } from 'vue'
import { RouterLink } from 'vue-router'

const global = useGlobalStore()

const { request } = global
const { isLoading } = storeToRefs(global)

const form = reactive({
  name: '',
  email: '',
  password: ''
})

async function register() {
  isLoading.value = true

  try {
    await request({
      method: 'POST',
      url: '/register',
      data: form
    })

    swal('Success', 'Register successfully', 'success')
    isLoading.value = false
    router.push('/login')
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
  <div class="min-h-screen flex justify-center items-center">
    <Loader v-show="isLoading" />
    <div class="w-96">
      <Card class="p-8">
        <h1 class="text-center text-4xl font-bold mb-5">Register</h1>
        <form @submit.prevent="register" autocomplete="off">
          <div class="flex flex-col mb-5">
            <div class="flex flex-col mb-3">
              <label for="name">Name</label>
              <input
                v-model="form.name"
                class="focus:outline-none focus:ring focus:ring-violet-300 rounded border h-8"
                type="text"
                name="name"
                id="name"
              />
            </div>
            <div class="flex flex-col mb-3">
              <label for="email">Email</label>
              <input
                v-model="form.email"
                class="focus:outline-none focus:ring focus:ring-violet-300 rounded border h-8"
                type="email"
                name="email"
                id="email"
              />
            </div>
            <div class="flex flex-col mb-3">
              <label for="password">Password</label>
              <input
                v-model="form.password"
                class="focus:outline-none focus:ring focus:ring-violet-300 rounded border h-8"
                type="password"
                name="password"
                id="password"
              />
            </div>
          </div>

          <div class="flex flex-col">
            <button type="submit" class="bg-indigo-500 text-white p-1 rounded hover:bg-indigo-700">
              Sign Up
            </button>
            <p class="text-center">
              Already have an account?
              <RouterLink to="/login" class="text-sky-500 hover:text-sky-700"> Sign In </RouterLink>
            </p>
          </div>
        </form>
      </Card>
    </div>
  </div>
</template>
