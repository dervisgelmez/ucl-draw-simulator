<template>
  <div class="flex flex-col w-full gap-10">
    <SimulateBar :fixture="fixture" />

    <component
      class="w-full bg-white rounded-lg"
      v-if="fixture"
      :is="getComponentsByStage"
      :fixture="fixture"
    />

    <MatchDrawer />
  </div>
</template>

<script setup lang="ts">
import { computed, markRaw } from 'vue'
import { type Fixture, FixtureStages } from '@/types/fixture.ts'
import FixtureGroupStage from '@/components/fixture/stages/FixtureGroupStage.vue'
import SimulateBar from '@/components/simulate/SimulateBar.vue'
import FixtureRoundStage from '@/components/fixture/stages/FixtureRoundStage.vue'
import FixtureQuarterStage from '@/components/fixture/stages/FixtureQuarterStage.vue'
import FixtureSemiStage from '@/components/fixture/stages/FixtureSemiStage.vue'
import FixtureFinalStage from '@/components/fixture/stages/FixtureFinalStage.vue'
import MatchDrawer from '@/components/match/MatchDrawer.vue'

interface IFixtureDashboardProps {
  fixture: Fixture
}

const props = defineProps<IFixtureDashboardProps>()

const stageComponents = markRaw({
  [FixtureStages.GROUP]: FixtureGroupStage,
  [FixtureStages.ROUND]: FixtureRoundStage,
  [FixtureStages.QUARTER]: FixtureQuarterStage,
  [FixtureStages.SEMI]: FixtureSemiStage,
  [FixtureStages.FINAL]: FixtureFinalStage
})

const getComponentsByStage = computed(() => {
  return stageComponents[props.fixture.stage.name as keyof typeof stageComponents] ?? null
})
</script>
