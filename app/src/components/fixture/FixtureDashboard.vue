<template>
  <div class="flex flex-col w-full gap-10">
    <div class="flex sticky top-0 p-3 bottom-0 rounded-lg left-0 bg-gray-50 border border-gray-200 w-full gap-5">
      <div
        @click="resetFixture"
        type="button"
        class="text-indigo-600 cursor-pointer text-base font-bold"
      >
        Simulate All Weeks
      </div>

      <div
        @click="resetFixture"
        type="button"
        class="text-rose-600 cursor-pointer text-base font-bold"
      >
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

interface IFixtureDashboardProps {
  fixture: Fixture
}

const props = defineProps<IFixtureDashboardProps>()

const { resetFixture } = useFixtureStore()

const stageComponents = markRaw({
  [FixtureStages.GROUP]: FixtureGroupStage,
})

const getComponentsByStage = computed(() => {
  return stageComponents[props.fixture.stage.name as keyof typeof stageComponents] ?? null
})
</script>
