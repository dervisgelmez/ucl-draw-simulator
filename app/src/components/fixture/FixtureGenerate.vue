<template>
  <NSpin :show="loading">
    <div class="flex flex-col w-12/12 xl:w-6/12 gap-10 mx-auto">
      <div class="text-center">
        <p class="text-gray-500">There is no fixture yet. Would you like to create one?</p>
        <button
          @click="generateFixture"
          type="button"
          class="text-indigo-800 border border-indigo-800 hover:bg-indigo-800 hover:text-white rounded-lg cursor-pointer font-bold mt-2 px-3 py-2"
        >
          Generate Fixture
        </button>
      </div>

      <div class="grid grid-cols-2 md:grid-cols-4 xl:grid-cols-8">
        <div
          v-for="team in teams"
          :key="team.id"
          class="flex border p-5 border-gray-200 justify-center items-center"
        >
          <img class="h-12" :src="team.logo" :alt="team.name" />
        </div>
      </div>
    </div>
  </NSpin>
</template>

<script setup lang="ts">
import { useTeamStore } from '@/stores/team.store.ts'
import { storeToRefs } from 'pinia'
import { onMounted } from 'vue'
import { NSpin } from 'naive-ui'
import { useApiRequest } from '@/composables/useApiRequest.ts'
import { useFixtureStore } from '@/stores/fixture.store.ts'

const { fetchTeams } = useTeamStore()
const { fetchFixture } = useFixtureStore()
const { teams } = storeToRefs(useTeamStore())

const { request, loading } = useApiRequest()

const generateFixture = async () => {
  await request('/fixtures', { method: 'POST' })
  await fetchFixture()
}

onMounted(async () => {
  await fetchFixture()
  await fetchTeams()
})
</script>
