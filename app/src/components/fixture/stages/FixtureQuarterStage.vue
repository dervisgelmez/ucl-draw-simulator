<template>
  <div class="flex flex-col gap-10">
    <h5 v-if="!props.clear" class="font-bold text-3xl text-center">QUARTER FINAL</h5>

    <n-collapse v-if="!props.clear">
      <n-collapse-item title="Group Stage" name="group_stage">
        <div class="p-10 border border-gray-200 rounded-lg">
          <FixtureGroupStage clear :fixture="fixture" />
        </div>
      </n-collapse-item>
      <n-collapse-item title="Round 16" name="round_16">
        <div class="p-10 border border-gray-200 rounded-lg">
          <FixtureRoundStage clear :fixture="fixture" />
        </div>
      </n-collapse-item>
    </n-collapse>

    <div class="order-2 lg:order-1" v-if="quarterMatches.length">
      <div>
        <n-tabs v-model:value="activeTab" type="line" animated>
          <n-tab-pane
            :key="id"
            v-for="(matches, id, index) in getMatchesByWeekly"
            :tab="`Leg ${index + 1}`"
            :name="`leg_${id}`"
          >
            <div class="grid grid-cols-1 pt-3 gap-5">
              <div class="flex" :key="match.id" v-for="match in matches">
                <MatchCard :match="match" />
              </div>
            </div>
          </n-tab-pane>
        </n-tabs>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import {
  type FixtureMatch,
  FixtureStages,
  type IFixtureStageComponentsProps,
} from '@/types/fixture.ts'
import FixtureGroupStage from '@/components/fixture/stages/FixtureGroupStage.vue'
import { NCollapse, NCollapseItem, NTabPane, NTabs } from 'naive-ui'
import { computed, onMounted, ref, type Ref, watch } from 'vue'
import { useFixtureStore } from '@/stores/fixture.store.ts'
import { storeToRefs } from 'pinia'
import MatchCard from '@/components/match/MatchCard.vue'
import FixtureRoundStage from '@/components/fixture/stages/FixtureRoundStage.vue'

const props = defineProps<IFixtureStageComponentsProps>()

const { fetchFixtureMatches } = useFixtureStore()
const { fixtureMatches } = storeToRefs(useFixtureStore())

const normalizeWeek = (week: number) => Math.min(week, 10)
const activeTab = ref(`leg_${normalizeWeek(props.fixture.week)}`)

const quarterMatches: Ref<Array<FixtureMatch>> = computed(() => {
  return fixtureMatches.value[FixtureStages.QUARTER]
})

const getMatchesByWeekly = computed(() => {
  return quarterMatches.value.reduce((acc: Record<number, FixtureMatch[]>, match: FixtureMatch) => {
    const week = match.week
    if (!acc[week]) {
      acc[week] = []
    }
    acc[week].push(match)
    return acc
  }, {})
})

watch(
  () => props.fixture.week,
  (newWeek) => {
    activeTab.value = `leg_${normalizeWeek(newWeek)}`
  }
)

onMounted(async () => {
  await fetchFixtureMatches(FixtureStages.QUARTER)
})
</script>
