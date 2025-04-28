<template>
  <div
    v-if="!finalMatch.completedAt"
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
import {
  type FixtureMatch,
  FixtureStages,
  type IFixtureStageComponentsProps
} from '@/types/fixture.ts'
import { storeToRefs } from 'pinia'
import { computed, type Ref } from 'vue'

const props = defineProps<IFixtureStageComponentsProps>()

const { request } = useApiRequest()
const { resetFixtureMatch, fetchFixtureMatches } = useFixtureStore()
const { fixtureMatches } = storeToRefs(useFixtureStore())

const finalMatch: Ref<FixtureMatch> = computed(() => {
  return fixtureMatches.value[FixtureStages.FINAL][0]
})

const applySimulate = async () => {
  resetFixtureMatch(FixtureStages.FINAL)
  await fetchFixtureMatches(FixtureStages.FINAL)
}

const simulateFinal = async () => {
  await request(`/fixtures/${props.fixture.id}/simulate/final`, { method: 'POST' })
  await applySimulate()
}
</script>
