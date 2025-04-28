<template>
  <div class="flex flex-col w-full gap-10">
    <SimulateBar :fixture="fixture" />

    <component
      class="w-full bg-white rounded-lg"
      v-if="fixture"
      :is="getComponentsByStage"
      :fixture="fixture"
    />
  </div>
</template>

<script setup lang="ts">
import { computed, markRaw } from 'vue'
import { type Fixture, FixtureStages } from '@/types/fixture.ts'
import FixtureGroupStage from '@/components/fixture/stages/FixtureGroupStage.vue'
import SimulateBar from '@/components/simulate/SimulateBar.vue'
import FixtureRoundStage from '@/components/fixture/stages/FixtureRoundStage.vue'

interface IFixtureDashboardProps {
  fixture: Fixture
}

const props = defineProps<IFixtureDashboardProps>()

const stageComponents = markRaw({
  [FixtureStages.GROUP]: FixtureGroupStage,
  [FixtureStages.ROUND]: FixtureRoundStage
})

const getComponentsByStage = computed(() => {
  return stageComponents[props.fixture.stage.name as keyof typeof stageComponents] ?? null
})
</script>
