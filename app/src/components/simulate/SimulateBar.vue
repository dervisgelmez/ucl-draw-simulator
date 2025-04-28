<template>
  <div
    class="flex divide-x-2 sticky top-0 p-3 bottom-0 z-10 rounded-lg left-0 bg-gray-50 border border-gray-200 w-full gap-5"
  >
    <component
      v-if="fixture"
      :is="getComponentsByStage"
      :fixture="fixture"
    />

    <div
      @click="resetFixture"
      type="button"
      class="flex items-center gap-1 text-rose-600 cursor-pointer text-base border-gray-200"
    >
      <Icon icon="bx:reset" />
      Reset Fixture
    </div>
  </div>
</template>

<script setup lang="ts">
import { Icon } from '@iconify/vue'
import { type Fixture, FixtureStages } from '@/types/fixture.ts'
import { computed, markRaw } from 'vue'
import { useFixtureStore } from '@/stores/fixture.store.ts'
import BarGroupStage from '@/components/simulate/stages/BarGroupStage.vue'
import BarRoundStage from '@/components/simulate/stages/BarRoundStage.vue'
import BarQuarterStage from '@/components/simulate/stages/BarQuarterStage.vue'
import BarSemiStage from '@/components/simulate/stages/BarSemiStage.vue'
import BarFinalStage from '@/components/simulate/stages/BarFinalStage.vue'

const { resetFixture } = useFixtureStore()

interface ISimulateBarProps {
  fixture: Fixture
}

const props = defineProps<ISimulateBarProps>()

const stageComponents = markRaw({
  [FixtureStages.GROUP]: BarGroupStage,
  [FixtureStages.ROUND]: BarRoundStage,
  [FixtureStages.QUARTER]: BarQuarterStage,
  [FixtureStages.SEMI]: BarSemiStage,
  [FixtureStages.FINAL]: BarFinalStage
})

const getComponentsByStage = computed(() => {
  return stageComponents[props.fixture.stage.name as keyof typeof stageComponents] ?? null
})
</script>
