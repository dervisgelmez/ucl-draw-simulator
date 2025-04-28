<template>
  <div
    @click="simulateWeeks"
    type="button"
    class="flex items-center gap-1 text-indigo-600 cursor-pointer text-base border-gray-200 pr-3"
  >
    <Icon icon="mdi:play" />
    Simulate <b>Weeks {{ props.fixture.week }}</b>
  </div>

  <div
    @click="simulateGroup"
    type="button"
    class="flex items-center gap-1 text-indigo-600 cursor-pointer text-base border-gray-200 pr-3"
  >
    <Icon icon="ph:caret-double-right-fill" />
    Simulate All Weeks
  </div>
</template>

<script setup lang="ts">
import { Icon } from '@iconify/vue'
import { useApiRequest } from '@/composables/useApiRequest.ts'
import { useFixtureStore } from '@/stores/fixture.store.ts'
import type { IFixtureStageComponentsProps } from '@/types/fixture.ts'

const props = defineProps<IFixtureStageComponentsProps>()

const { request } = useApiRequest()
const { updateFixture, fetchFixtureGroups, fetchFixtureMatches, resetDashboard } = useFixtureStore()

const applySimulate = async () => {
  resetDashboard()
  await updateFixture()
  await fetchFixtureGroups()
  await fetchFixtureMatches()
}

const simulateWeeks = async () => {
  await request(`/fixtures/${props.fixture.id}/simulate/weekly`, { method: 'POST' })
  await applySimulate()
}

const simulateGroup = async () => {
  await request(`/fixtures/${props.fixture.id}/simulate/groups`, { method: 'POST' })
  await applySimulate()
}
</script>
