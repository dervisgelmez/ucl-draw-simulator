<template>
  <div class="flex flex-col gap-10">
    <div v-if="fixtureGroups.length">
      <h4 class="pb-10 text-gray-700 text-3xl">Groups</h4>
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5">
        <div
          class="border border-gray-200 rounded-lg"
          :key="group.id"
          v-for="group in fixtureGroups"
        >
          <h5 class="bg-gray-100 font-bold p-3 cursor-default">{{ group.name }}</h5>

          <div class="flex flex-col">
            <div
              class="flex justify-between border-b border-gray-200 rounded-lg p-2"
              :key="team.id"
              v-for="team in group.teams"
            >
              <div class="flex gap-3 items-center">
                <img class="w-4 h-4" :src="team.logo" :alt="team.name" />
                <span class="text-sm">{{ team.name }}</span>
              </div>
              <span class="font-bold">20</span>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div>
      <div v-if="fixtureMatches.length">
        <h4 class="pb-10 text-gray-700 text-3xl">Matches</h4>
        <div>
          <n-tabs type="line" animated>
            <n-tab-pane
              :key="id"
              v-for="(matches, id) in getMatchesByWeekly"
              :tab="`Week ${id}`"
              :name="`Week ${id}`"
            >
              <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div class="flex" :key="match.id" v-for="match in matches">
                  <MatchCard :match="match" />
                </div>
              </div>
            </n-tab-pane>
          </n-tabs>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import type { FixtureMatch, IFixtureStageComponentsProps } from '@/types/fixture.ts'
import { computed, onMounted, ref } from 'vue'
import { NTabs, NTabPane } from 'naive-ui'
import { useApiRequest } from '@/composables/useApiRequest.ts'
import { useFixtureStore } from '@/stores/fixture.store.ts'
import { storeToRefs } from 'pinia'
import MatchCard from '@/components/match/MatchCard.vue'

const props = defineProps<IFixtureStageComponentsProps>()

const { data, request, loading } = useApiRequest()
const { setFixtureGroups, setFixtureMatches } = useFixtureStore()
const { fixtureGroups, fixtureMatches } = storeToRefs(useFixtureStore())

const fetchGroups = async () => {
  await request(`/fixtures/${props.fixture.id}/groups`, { method: 'GET' })
  setFixtureGroups(data.value ?? [])
}

const fetchMatches = async () => {
  await request(`/fixtures/${props.fixture.id}/matches`, { method: 'GET' })
  setFixtureMatches(data.value ?? [])
}

const getMatchesByWeekly = computed(() => {
  return fixtureMatches.value.reduce(
    (acc: Record<number, FixtureMatch[]>, match: FixtureMatch) => {
      const week = match.week
      if (!acc[week]) {
        acc[week] = []
      }
      acc[week].push(match)
      return acc
    },
    {},
  )
})

onMounted(async () => {
  if (fixtureGroups.value.length === 0) {
    await fetchGroups()
  }
  if (fixtureMatches.value.length === 0) {
    await fetchMatches()
  }
})
</script>
