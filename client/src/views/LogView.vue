<script setup lang="ts">
import Card from '@/components/Card.vue'
import { useLogStore } from '@/stores/log'
import { storeToRefs } from 'pinia'

const logStore = useLogStore()

const { logs } = storeToRefs(logStore)
</script>

<template>
  <h1 class="text-3xl font-bold">Logs</h1>

  <Card class="p-5 my-5">
    <table class="table-auto w-full text-center">
      <thead class="text-slate-700">
        <tr>
          <th class="p-4">No</th>
          <th class="p-4">User</th>
          <th class="p-4">Description</th>
          <th class="p-4">Date</th>
        </tr>
      </thead>
      <tbody class="text-slate-500">
        <tr v-for="(log, i) in logs" :key="log.id">
          <td class="p-4">{{ i + 1 }}</td>
          <td class="p-4">{{ log.user.name }}</td>
          <td class="p-4">{{ log.description }}</td>
          <td class="p-4">{{ log.created_at }}</td>
        </tr>
      </tbody>
    </table>
  </Card>
</template>
