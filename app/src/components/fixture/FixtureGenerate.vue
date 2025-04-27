<template>
  <NSpin :show="loading">
    <div class="flex flex-col w-6/12 gap-10 mx-auto">
      <div class="grid grid-cols-8">
        <div
          v-for="team in teams"
          :key="team.id"
          class="flex border p-5 border-gray-200 justify-center items-center"
        >
          <img class="h-12" :src="team.logo" :alt="team.name" />
        </div>
      </div>

      <div class="text-center">
        <p class="text-gray-500">There is no fixture yet. Would you like to create one?</p>
        <p
          @click="generateFixture"
          type="button"
          class="text-indigo-800 cursor-pointer text-base font-bold py-3"
        >
          Generate Fixture
        </p>
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
  await request('api/fixtures', { method: 'POST' })
  await fetchFixture()
}

onMounted(async () => {
  await fetchFixture()
  await fetchTeams()
})
</script>
