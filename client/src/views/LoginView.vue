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

const { isLogin } = storeToRefs(global)

const isLoading = ref(false)

const form = reactive({
  email: '',
  password: ''
})

async function login() {
  isLoading.value = true

  try {
    const { data } = await request({
      method: 'POST',
      url: '/login',
      data: form
    })

    swal('Success', 'Login successfully', 'success')
    isLoading.value = false
    isLogin.value = true
    localStorage.setItem('access_token', `Bearer ${data.token}`)
    router.push('/')
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
        <h1 class="text-center text-4xl font-bold mb-5">Login</h1>
        <form @submit.prevent="login" autocomplete="off">
          <div class="flex flex-col mb-5">
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
              Sign In
            </button>
            <p class="text-center">
              Don't have an account?
              <RouterLink to="/register" class="text-sky-500 hover:text-sky-700">
                Sign Up
              </RouterLink>
            </p>
          </div>
        </form>
      </Card>
    </div>
  </div>
</template>
