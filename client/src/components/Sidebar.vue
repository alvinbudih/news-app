<script setup lang="ts">
import { RouterLink } from 'vue-router'
</script>

<template>
  <aside class="bg-white min-w-64 sticky top-0 min-h-screen max-h-screen flex flex-col gap-6">
    <h2 class="text-3xl font-bold mt-7 ml-7 text-indigo-500">E-Wallet</h2>

    <ul class="flex flex-col ml-1 font-semibold">
      <li class="w-full h-fit flex items-center text-slate-400">
        <RouterLink
          to="/"
          class="p-4 w-full"
          exact-active-class="text-indigo-500 bg-indigo-50 border-l-4 border-indigo-500"
        >
          Dashboard
        </RouterLink>
      </li>
      <li class="w-full h-fit flex items-center text-slate-400">
        <RouterLink
          to="/news"
          class="p-4 w-full"
          exact-active-class="text-indigo-500 bg-indigo-50 border-l-4 border-indigo-500"
        >
          News
        </RouterLink>
      </li>
      <li class="w-full h-fit flex items-center text-slate-400">
        <RouterLink
          to="/logs"
          class="p-4 w-full"
          exact-active-class="text-indigo-500 bg-indigo-50 border-l-4 border-indigo-500"
        >
          Logs
        </RouterLink>
      </li>
      <li class="w-full h-14 flex items-center text-slate-400">
        <a href="/" class="p-4 w-full">Logout</a>
      </li>
    </ul>
  </aside>
</template>
