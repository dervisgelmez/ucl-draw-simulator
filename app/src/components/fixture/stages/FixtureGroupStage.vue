<template>
  <div class="flex flex-col xl:flex-row gap-10">
    <div class="w-full order-1 lg:order-2" v-if="fixtureGroups.length">
      <h4 class="pb-10 text-gray-700 text-2xl">Groups</h4>
      <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
        <div :key="group.id" v-for="group in fixtureGroups">
          <div class="overflow-x-auto border border-gray-200 rounded-lg overflow-hidden">
            <table class="w-full text-sm text-center">
              <thead class="bg-gray-200 text-black">
                <tr>
                  <th class="px-6 py-3 text-left">{{ group.name }}</th>
                  <th class="px-6 py-3">P</th>
                  <th class="px-6 py-3">GD</th>
                  <th class="px-6 py-3">Pts</th>
                </tr>
              </thead>
              <tbody class="bg-white divide-y divide-gray-200">
                <tr :key="team.id" v-for="team in getSortedTeams(group.teams)">
                  <td class="px-6 py-4 text-left">
                    <div class="flex gap-3 items-center">
                      <img class="w-4 h-4" :src="team.logo" :alt="team.name" />
                      <span class="text-sm">{{ team.name }}</span>
                    </div>
                  </td>

                  <td class="px-6 py-4">
                    {{ team.attributes.played }}
                  </td>
                  <td class="px-6 py-4">
                    {{ team.attributes.average }}
                  </td>
                  <td class="px-6 py-4">
                    {{ team.attributes.points }}
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>

    <div class="order-2 lg:order-1" v-if="fixtureMatches.length">
      <h4 class="pb-10 text-gray-700 text-2xl">Matches</h4>
      <div>
        <n-tabs v-model:value="activeTab" type="line" animated>
          <n-tab-pane
            :key="id"
            v-for="(matches, id) in getMatchesByWeekly"
            :tab="`Week ${id}`"
            :name="`Week ${id}`"
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
import type {
  FixtureGroupTeam,
  FixtureMatch,
  IFixtureStageComponentsProps,
} from '@/types/fixture.ts'
import { computed, onMounted, ref, watch } from 'vue'
import { NTabs, NTabPane } from 'naive-ui'
import { useFixtureStore } from '@/stores/fixture.store.ts'
import { storeToRefs } from 'pinia'
import MatchCard from '@/components/match/MatchCard.vue'

const props = defineProps<IFixtureStageComponentsProps>()

const activeTab = ref(`Week ${props.fixture.week}`)
const { fetchFixtureGroups, fetchFixtureMatches } = useFixtureStore()
const { fixtureGroups, fixtureMatches } = storeToRefs(useFixtureStore())

const getMatchesByWeekly = computed(() => {
  return fixtureMatches.value.reduce((acc: Record<number, FixtureMatch[]>, match: FixtureMatch) => {
    const week = match.week
    if (!acc[week]) {
      acc[week] = []
    }
    acc[week].push(match)
    return acc
  }, {})
})

const getSortedTeams = (teams: FixtureGroupTeam[]) => {
  return [...teams].sort((a, b) => {
    if (b.attributes.points === a.attributes.points) {
      return b.attributes.average - a.attributes.average
    }
    return b.attributes.points - a.attributes.points
  })
}

watch(() => props.fixture.week, (newWeek) => {
  activeTab.value = `Week ${newWeek}`
})

onMounted(async () => {
  await fetchFixtureGroups()
  await fetchFixtureMatches()
})
</script>
