<template>
  <div class="flex flex-col gap-10">
    <div>
      <n-collapse>
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
        <n-collapse-item title="Quarter Final" name="quarter_final">
          <div class="p-10 border border-gray-200 rounded-lg">
            <FixtureQuarterStage clear :fixture="fixture" />
          </div>
        </n-collapse-item>
        <n-collapse-item title="Semi Final" name="semi_final">
          <div class="p-10 border border-gray-200 rounded-lg">
            <FixtureSemiStage clear :fixture="fixture" />
          </div>
        </n-collapse-item>
      </n-collapse>
    </div>
    <h5 class="font-bold text-3xl text-center">🏆 FINAL</h5>

    <div v-if="finalMatch">
      <div class="grid grid-cols-1 pt-3 gap-5">
        <MatchCard :match="finalMatch" />
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
import { NCollapse, NCollapseItem } from 'naive-ui'
import { computed, onMounted, ref, type Ref, watch } from 'vue'
import { useFixtureStore } from '@/stores/fixture.store.ts'
import { storeToRefs } from 'pinia'
import MatchCard from '@/components/match/MatchCard.vue'
import FixtureRoundStage from '@/components/fixture/stages/FixtureRoundStage.vue'
import FixtureQuarterStage from '@/components/fixture/stages/FixtureQuarterStage.vue'
import FixtureSemiStage from '@/components/fixture/stages/FixtureSemiStage.vue'
import confetti from 'canvas-confetti'

const props = defineProps<IFixtureStageComponentsProps>()

const { fetchFixtureMatches } = useFixtureStore()
const { fixtureMatches } = storeToRefs(useFixtureStore())

const activeTab = ref(`leg_${props.fixture.week}`)

const finalMatch: Ref<FixtureMatch> = computed(() => {
  return fixtureMatches.value[FixtureStages.FINAL][0]
})

watch(
  () => props.fixture.week,
  (newWeek) => {
    activeTab.value = `leg_${newWeek}`
  },
)

watch(
  () => finalMatch.value,
  (match: FixtureMatch) => {
    if (match.completedAt) {
      confetti({
        particleCount: 300,
        spread: 200,
        origin: { y: 0.6 },
      })
    }
  },
)

onMounted(async () => {
  await fetchFixtureMatches(FixtureStages.FINAL)
})
</script>
