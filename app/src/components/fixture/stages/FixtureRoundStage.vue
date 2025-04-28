<template>
  <div class="flex flex-col gap-10">
    <n-collapse>
      <n-collapse-item title="Group Stage" name="group_stage">
        <div class="p-10 border border-gray-200 rounded-lg">
          <FixtureGroupStage :fixture="fixture" />
        </div>
      </n-collapse-item>
    </n-collapse>

    ROUND 16 AREA

    {{ roundMatches }}
  </div>
</template>

<script setup lang="ts">
import {
  type FixtureMatch,
  FixtureStages,
  type IFixtureStageComponentsProps,
} from '@/types/fixture.ts'
import FixtureGroupStage from '@/components/fixture/stages/FixtureGroupStage.vue'
import { NCollapse, NCollapseItem } from 'naive-ui'
import { computed, onMounted, type Ref } from 'vue'
import { useFixtureStore } from '@/stores/fixture.store.ts'
import { storeToRefs } from 'pinia'

defineProps<IFixtureStageComponentsProps>()

const { fetchFixtureMatches } = useFixtureStore()
const { fixtureMatches } = storeToRefs(useFixtureStore())

const roundMatches: Ref<Array<FixtureMatch>> = computed(() => {
  return fixtureMatches.value[FixtureStages.ROUND]
})

onMounted(async () => {
  await fetchFixtureMatches(FixtureStages.ROUND)
})
</script>
