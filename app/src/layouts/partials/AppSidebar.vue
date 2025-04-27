<template>
  <aside class="hidden sm:flex flex-col bg-gray-50 items-center gap-20 p-10 border-r border-gray-200">
    <img src="/icons/logo.svg" alt="Logo" height="60" />

    <ul class="flex flex-col gap-10">
      <li v-for="(route, index) in getNavigationRoutes()" :key="index">
        <RouterLink exact-active-class="active" v-slot="{ isActive }" :to="route">
          <div
            class="flex justify-center p-3 cursor-pointer rounded-xl"
            :class="{
              'bg-indigo-600 text-white': isActive,
              'text-zinc-600': !isActive,
            }"
          >
            <Icon :icon="route.meta?.icon as string" height="32" />
          </div>
        </RouterLink>
      </li>
    </ul>
  </aside>
</template>

<script setup lang="ts">
import { Icon } from '@iconify/vue'
import { useUserRouter } from '@/composables/useUserRouter.ts'

const { getNavigationRoutes } = useUserRouter()
</script>
