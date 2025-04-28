<template>
  <div
    @click="simulateLegs"
    type="button"
    class="flex items-center gap-1 text-indigo-600 cursor-pointer text-base border-gray-200 pr-3"
  >
    <Icon icon="mdi:play" />
    Simulate Semi <b>Leg {{ fixture.week - 10 }}</b>
  </div>
  <div
    @click="simulateSemi"
    type="button"
    class="flex items-center gap-1 text-indigo-600 cursor-pointer text-base border-gray-200 pr-3"
  >
    <Icon icon="mdi:play" />
    Simulate Semi Final
  </div>
</template>

<script setup lang="ts">
import { Icon } from '@iconify/vue'
import { useApiRequest } from '@/composables/useApiRequest.ts'
import { useFixtureStore } from '@/stores/fixture.store.ts'
import { FixtureStages, type IFixtureStageComponentsProps } from '@/types/fixture.ts'

const props = defineProps<IFixtureStageComponentsProps>()

const { request } = useApiRequest()
const { resetFixtureMatch, fetchFixtureMatches } = useFixtureStore()

const applySimulate = async () => {
  resetFixtureMatch(FixtureStages.SEMI)
  await fetchFixtureMatches(FixtureStages.SEMI)
}

const simulateLegs = async () => {
  await request(`/fixtures/${props.fixture.id}/simulate/semi-legs`, { method: 'POST' })
  await applySimulate()
}

const simulateSemi = async () => {
  await request(`/fixtures/${props.fixture.id}/simulate/semi`, { method: 'POST' })
  await applySimulate()
}
</script>
