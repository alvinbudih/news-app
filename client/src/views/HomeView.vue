<script setup lang="ts">
import Loader from '@/components/Loader.vue'
import Sidebar from '@/components/Sidebar.vue'
import { useDataStore } from '@/stores/data'
import { useGlobalStore } from '@/stores/global'
import { storeToRefs } from 'pinia'

const { fetchAll } = useDataStore()

const global = useGlobalStore()

const { isLoading } = storeToRefs(global)

isLoading.value = true
fetchAll().finally(() => {
  isLoading.value = false
})
</script>

<template>
  <div class="min-h-screen flex">
    <Loader v-show="isLoading" />
    <Sidebar />
    <div class="grow p-7">
      <RouterView />
    </div>
  </div>
</template>
