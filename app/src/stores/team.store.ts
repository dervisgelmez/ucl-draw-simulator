import { defineStore } from 'pinia'
import type { Team } from '@/types/teams'
import { ref } from 'vue'
import { useApiRequest } from '@/composables/useApiRequest.ts'

export const useTeamStore = defineStore('team', () => {
  const teams = ref<Array<Team>>([] as Team[])

  const setTeams = (data: Team[]) => {
    teams.value = data
  }

  const fetchTeams = async () => {
    if (teams.value.length > 0) {
      return;
    }

    const { data } = await useApiRequest().request('/teams', { method: 'GET' })
    teams.value = (data.value ?? []) as Team[]
  }

  return {
    teams,
    setTeams,
    fetchTeams
  }
})
