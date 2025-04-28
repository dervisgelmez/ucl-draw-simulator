import { ref } from 'vue'
import { defineStore } from 'pinia'
import { useApiRequest } from '@/composables/useApiRequest.ts'
import type { Fixture, FixtureGroup, FixtureMatch } from '@/types/fixture.ts'
import type { Team } from '@/types/teams.ts'

export const useFixtureStore = defineStore('fixture', () => {
  const fixture = ref<Fixture | null>(null)
  const fixtureGroups = ref<Array<FixtureGroup>>([] as FixtureGroup[])
  const fixtureMatches = ref<Array<FixtureMatch>>([] as FixtureMatch[])

  const fetchFixture = async () => {
    if (fixture.value) {
      return
    }

    const { data } = await useApiRequest().request('/fixtures', { method: 'GET' })
    fixture.value = data.value ?? null
  }

  const updateFixture = async () => {
    const { data } = await useApiRequest().request('/fixtures', { method: 'GET' })
    fixture.value = data.value ?? null
  }

  const fetchFixtureGroups = async () => {
    if (fixtureGroups.value.length > 0) {
      return []
    }

    const { data } = await useApiRequest().request(`/fixtures/${fixture.value?.id}/groups`, { method: 'GET' })
    fixtureGroups.value = (data.value ?? []) as FixtureGroup[]
  }

  const fetchFixtureMatches = async () => {
    if (fixtureMatches.value.length > 0) {
      return []
    }

    const { data } = await useApiRequest().request(`/fixtures/${fixture.value?.id}/matches`, { method: 'GET' })
    fixtureMatches.value = (data.value ?? []) as FixtureMatch[]
  }

  const resetFixture = async () => {
    await useApiRequest().request(`/fixtures/${fixture.value?.id}`, { method: 'DELETE' })
    resetStore()
  }

  const resetDashboard = () => {
    fixtureGroups.value = []
    fixtureMatches.value = []
  }

  const resetStore = () => {
    fixture.value = null
    fixtureGroups.value = []
    fixtureMatches.value = []
  }

  return {
    fixture,
    fixtureGroups,
    fixtureMatches,
    fetchFixture,
    updateFixture,
    fetchFixtureGroups,
    fetchFixtureMatches,
    resetFixture,
    resetDashboard
  }
})
