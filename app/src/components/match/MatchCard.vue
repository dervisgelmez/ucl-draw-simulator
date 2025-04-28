<template>
  <div
    class="flex justify-between items-center w-full border border-gray-200 rounded-lg overflow-hidden"
  >
    <div
      class="flex w-full gap-5 items-center justify-start p-2 rounded border-l-10"
      :style="{
        borderColor: match.homeTeam.color,
      }"
    >
      <img class="w-8 h-8" :src="match.homeTeam.logo" :alt="match.homeTeam.name" />
      <span class="text-xs font-bold">{{ match.homeTeam.name }}</span>
    </div>
    <div class="w-full text-center">
      <div class="flex justify-evenly gap-2" v-if="match.completedAt">
        <span
          class="rounded-full px-2 font-bold text-xl"
          :class="getScoreClass(match.homeTeamScore, match.awayTeamScore)"
        >
          {{ match.homeTeamScore }}
        </span>

        <span
          class="rounded-full px-2 font-bold text-xl"
          :class="getScoreClass(match.awayTeamScore, match.homeTeamScore)"
        >
          {{ match.awayTeamScore }}
        </span>
      </div>
      <div v-else>
        <span class="text-xs text-gray-500">{{ match.date }}</span>
      </div>
    </div>

    <div
      class="flex w-full gap-5 items-center justify-end text-right p-2 rounded border-r-10"
      :style="{
        borderColor: match.awayTeam.color,
      }"
    >
      <span class="text-xs font-bold">{{ match.awayTeam.name }}</span>
      <img class="w-8 h-8" :src="match.awayTeam.logo" :alt="match.awayTeam.name" />
    </div>
  </div>
</template>

<script setup lang="ts">
import type { FixtureMatch } from '@/types/fixture.ts'

interface IMatchCardProps {
  match: FixtureMatch
}

const getScoreClass = (
  homeScore: number | null | undefined,
  awayScore: number | null | undefined,
) => {
  const score = homeScore ?? 0
  const opponent = awayScore ?? 0

  if (score > opponent) {
    return 'text-indigo-500'
  }
  return 'text-gray-400'
}

defineProps<IMatchCardProps>()
</script>
