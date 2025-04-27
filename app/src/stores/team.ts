import { defineStore } from 'pinia'
import type { Team } from '@/types/teams'

export const useTeamStore = defineStore('team', {
  state: () => ({
    teams: [] as Team[],
  }),
  actions: {
    setTeams(teams: Team[]) {
      this.teams = teams
    },
  },
})
