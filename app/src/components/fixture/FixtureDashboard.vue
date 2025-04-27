<template>
  <div class="flex flex-col w-full gap-10">
    <div
      class="flex sticky top-0 p-3 bottom-0 z-10 rounded-lg left-0 bg-gray-50 border border-gray-200 w-full gap-5"
    >
      <div
        @click="simulateWeek"
        type="button"
        class="flex items-center gap-1 text-indigo-600 cursor-pointer text-base"
      >
        <Icon icon="mdi:play" />
        Simulate <b>Weeks {{ props.fixture.week }}</b>
      </div>

      <div
        @click="simulateFixture"
        type="button"
        class="flex items-center gap-1 text-indigo-600 cursor-pointer text-base"
      >
        <Icon icon="ph:caret-double-right-fill" />
        Simulate All Weeks
      </div>

      <div
        @click="resetFixture"
        type="button"
        class="flex items-center gap-1 text-rose-600 cursor-pointer text-base"
      >
        <Icon icon="bx:reset" />
        Reset Fixture
      </div>
    </div>

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
import { useFixtureStore } from '@/stores/fixture.store.ts'
import { Icon } from '@iconify/vue'
import { useSimulateStore } from '@/stores/simulate.store.ts'

interface IFixtureDashboardProps {
  fixture: Fixture
}

const props = defineProps<IFixtureDashboardProps>()

const { resetFixture } = useFixtureStore()
const { simulateWeek, simulateFixture } = useSimulateStore()

const stageComponents = markRaw({
  [FixtureStages.GROUP]: FixtureGroupStage,
})

const getComponentsByStage = computed(() => {
  return stageComponents[props.fixture.stage.name as keyof typeof stageComponents] ?? null
})
</script>
