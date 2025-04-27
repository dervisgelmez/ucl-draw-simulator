<template>
  <n-data-table :columns="columns" :data="createData" />
</template>

<script setup lang="ts">
import type { DataTableColumns } from 'naive-ui'
import { NDataTable } from 'naive-ui'
import { computed, h, onMounted } from 'vue'
import type { Team } from '@/types/teams.ts'
import { useTeamStore } from '@/stores/team.store.ts'
import { storeToRefs } from 'pinia'

const { fetchTeams } = useTeamStore()
const { teams } = storeToRefs(useTeamStore())

const columns: DataTableColumns<Team> = [
  {
    title: 'Team',
    key: 'name',
    render(row: Team) {
      return h('div', { class: 'flex items-center gap-5' }, [
        h('img', {
          src: row.logo as string,
          alt: row.name,
          class: 'w-10 h-10 object-contain',
        }),
        h('b', row.name),
      ])
    },
  },
  {
    title: 'Country',
    key: 'country',
  },
  {
    title: 'Pot',
    key: 'pot',
  },
  {
    title: 'Attack',
    key: 'stats.attack',
  },
  {
    title: 'Midfield',
    key: 'stats.midfield',
  },
  {
    title: 'Defense',
    key: 'stats.defense',
  },
  {
    title: 'Speed',
    key: 'stats.speed',
  },
  {
    title: 'Pass',
    key: 'stats.pass',
  },
  {
    title: 'Shot',
    key: 'stats.shot',
  }
]

const createData = computed(() => {
  if (!teams.value) {
    return []
  }
  return teams.value
})

onMounted(async () => {
  if (teams.value.length > 0) {
    return
  }
  await fetchTeams()
})
</script>
