<template>
  <aside class="flex w-full items-center py-10 gap-10 justify-between">
    <div>
      <h5 class="text-2xl sm:text-6xl font-bold text-zinc-400">
        {{ router.currentRoute.value.meta?.title }}
      </h5>
    </div>
  </aside>
</template>

<script setup lang="ts">
import router from '@/router/index.router.ts'
</script>
