<template>
  <div class="flex w-full gap-10 mx-auto">
    <div class="bg-white border border-gray-100 rounded-lg shadow p-5">
      <h4 class="font-bold text-base text-gray-600">Matches</h4>
    </div>

    <component class="w-full bg-white rounded-lg" v-if="fixture" :is="getComponentsByStage" />
  </div>
</template>

<script setup lang="ts">
import { computed, markRaw } from 'vue'
import { type Fixture, FixtureStages } from '@/types/fixture.ts'
import FixtureGroupStage from '@/components/fixture/stages/FixtureGroupStage.vue'

interface IFixtureDashboardProps {
  fixture: Fixture
}

const props = defineProps<IFixtureDashboardProps>()

const stageComponents = markRaw({
  [FixtureStages.GROUP]: FixtureGroupStage,
})

const getComponentsByStage = computed(() => {
  return stageComponents[props.fixture.stage.name as keyof typeof stageComponents] ?? null
})
</script>
