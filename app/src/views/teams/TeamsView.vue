<template>
  <n-data-table :loading="loading" :columns="columns" :data="createData" />
</template>

<script setup lang="ts">
import type { DataTableColumns } from 'naive-ui'
import { NDataTable } from 'naive-ui'
import { computed, h, onMounted } from 'vue'
import { useApiRequest } from '@/composables/useApiRequest.ts'
import type { Team } from '@/types/teams.ts'
import { useTeamStore } from '@/stores/team.ts'
import { storeToRefs } from 'pinia'

const { setTeams } = useTeamStore()
const { teams } = storeToRefs(useTeamStore())

const { data: fetchedTeams, request, loading } = useApiRequest<Array<Team>>()

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
        h('span', row.name),
      ])
    },
  },
  {
    title: 'Country',
    key: 'country',
  },
  { title: 'Attack', key: 'stats.attack' },
  { title: 'Midfield', key: 'stats.midfield' },
  { title: 'Defense', key: 'stats.defense' },
  { title: 'Speed', key: 'stats.speed' },
  { title: 'Pass', key: 'stats.pass' },
  { title: 'Shot', key: 'stats.shot' },
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

  await request('api/teams', { method: 'GET' })
  setTeams(fetchedTeams.value || [])
})
</script>
