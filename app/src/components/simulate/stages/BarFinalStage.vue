<template>
  <div
    @click="simulateFinal"
    type="button"
    class="flex items-center gap-1 text-indigo-600 cursor-pointer text-base border-gray-200 pr-3"
  >
    <Icon icon="mdi:play" />
    Simulate For Champions
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
  resetFixtureMatch(FixtureStages.FINAL)
  await fetchFixtureMatches(FixtureStages.FINAL)
}

const simulateFinal = async () => {
  await request(`/fixtures/${props.fixture.id}/simulate/final`, { method: 'POST' })
  await applySimulate()
}
</script>
