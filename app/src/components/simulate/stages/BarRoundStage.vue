<template>
  <div
    @click="simulateLegs"
    type="button"
    class="flex items-center gap-1 text-indigo-600 cursor-pointer text-base border-gray-200 pr-3"
  >
    <Icon icon="mdi:play" />
    Simulate Round <b>Leg {{ fixture.week - 6 }}</b>
  </div>
  <div
    @click="simulateRound"
    type="button"
    class="flex items-center gap-1 text-indigo-600 cursor-pointer text-base border-gray-200 pr-3"
  >
    <Icon icon="mdi:play" />
    Simulate Round 16
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
  resetFixtureMatch(FixtureStages.ROUND)
  await fetchFixtureMatches(FixtureStages.ROUND)
}

const simulateLegs = async () => {
  await request(`/fixtures/${props.fixture.id}/simulate/round-legs`, { method: 'POST' })
  await applySimulate()
}

const simulateRound = async () => {
  await request(`/fixtures/${props.fixture.id}/simulate/rounds`, { method: 'POST' })
  await applySimulate()
}
</script>
