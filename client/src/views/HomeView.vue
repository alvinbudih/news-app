<script setup lang="ts">
import { useGlobalStore } from '@/stores/global'

const global = useGlobalStore()

const { request } = global

request({
  method: 'GET',
  url: '/logs',
  headers: {
    Authorization: localStorage.getItem('access_token')
  }
}).then(({ data }) => {
  console.log(data)
})
</script>

<template>
  <h1 class="text-3xl font-bold">Hello World</h1>
</template>
