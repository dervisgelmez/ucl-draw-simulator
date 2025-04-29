<template>
  <n-drawer v-if="match" v-model:show="showDrawer" :width="502" :placement="'right'">
    <n-drawer-content title="Match Detail">
      <div class="flex flex-col gap-10 py-10">
        <div>
          <MatchCard :detail="false" :match="match" />
        </div>
        <div>
          <n-timeline size="large" item-placement="right">
            <n-timeline-item
              v-for="(log, index) in match.logs"
              :key="index"
              :type="getLogTypeColor(log.type)"
              :title="`${log.minute.toString()}''`"
              :content="getLogContent(log.type)"
            />
          </n-timeline>
        </div>
      </div>
    </n-drawer-content>
  </n-drawer>
</template>

<script setup lang="ts">
import { NDrawer, NDrawerContent, NTimeline, NTimelineItem } from 'naive-ui'
import { useMatchStore } from '@/stores/matc.store.ts'
import { storeToRefs } from 'pinia'
import MatchCard from '@/components/match/MatchCard.vue'

const { match, showDrawer } = storeToRefs(useMatchStore())

const getLogTypeColor = (type: string) => {
  switch (type) {
    case 'goal':
    case 'penalty_goal':
    case 'free_kick_goal':
      return 'success'
    case 'penalty_miss':
    case 'free_kick_miss':
      return 'warning'
    case 'yellow_card':
      return 'warning'
    case 'red_card':
      return 'error'
    case 'injury':
      return 'error'
    case 'pass':
      return 'info'
    case 'penalty':
    case 'free_kick':
    case 'card':
      return 'info'
    default:
      return 'default'
  }
}

const getLogContent = (type: string) => {
  switch (type) {
    case 'goal':
      return 'Goal!'
    case 'penalty':
      return 'Penalty awarded'
    case 'penalty_goal':
      return 'Penalty scored!'
    case 'penalty_miss':
      return 'Penalty missed'
    case 'free_kick':
      return 'Free kick awarded'
    case 'free_kick_goal':
      return 'Goal from free kick!'
    case 'free_kick_miss':
      return 'Missed free kick'
    case 'yellow_card':
      return 'Yellow card shown'
    case 'red_card':
      return 'Red card shown'
    case 'card':
      return 'Card shown'
    case 'injury':
      return 'Injury occurred'
    case 'pass':
      return 'Pass completed'
    default:
      return 'Event'
  }
}
</script>
