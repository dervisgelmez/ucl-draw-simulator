<template>
  <div class="flex min-h-screen h-screen overflow-hidden">
    <AppSidebar />

    <div class="flex flex-col flex-1">
      <AppHeader class="h-auto px-10 shrink-0" />
      <main class="flex-1 my-5 px-10 overflow-y-auto">
        <RouterView />
      </main>
    </div>
  </div>
</template>

<script setup lang="ts">
import AppSidebar from '@/layouts/partials/AppSidebar.vue'
import AppHeader from '@/layouts/partials/AppHeader.vue'
</script>
