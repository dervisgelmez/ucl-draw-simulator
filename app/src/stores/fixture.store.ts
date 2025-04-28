import { ref } from 'vue'
import { defineStore } from 'pinia'
import { useApiRequest } from '@/composables/useApiRequest.ts'
import {
  type Fixture,
  type FixtureGroup,
  type FixtureMatch,
  FixtureStages,
} from '@/types/fixture.ts'

export const useFixtureStore = defineStore('fixture', () => {
  const fixture = ref<Fixture | null>(null)
  const fixtureGroups = ref<Array<FixtureGroup>>([] as FixtureGroup[])

  const fixtureMatches = ref<Record<FixtureStages, FixtureMatch[]>>({
    [FixtureStages.GROUP]: [],
    [FixtureStages.ROUND]: [],
    [FixtureStages.QUARTER]: [],
    [FixtureStages.SEMI]: [],
    [FixtureStages.FINAL]: [],
  })

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

    const { data } = await useApiRequest().request(`/fixtures/${fixture.value?.id}/groups`, {
      method: 'GET',
    })
    fixtureGroups.value = (data.value ?? []) as FixtureGroup[]
  }

  const fetchFixtureMatches = async (stage: FixtureStages = FixtureStages.GROUP) => {
    if (fixtureMatches.value[stage].length > 0) {
      return []
    }

    const { data } = await useApiRequest().request(
      `/fixtures/${fixture.value?.id}/matches?stage=${stage}`,
      { method: 'GET' },
    )
    fixtureMatches.value[stage] = (data.value ?? []) as FixtureMatch[]
  }

  const resetFixture = async () => {
    await useApiRequest().request(`/fixtures/${fixture.value?.id}`, { method: 'DELETE' })
    resetStore()
  }

  const resetDashboard = () => {
    fixtureGroups.value = []
    resetFixtureMatches()
  }

  const resetFixtureMatch = (stage: FixtureStages = FixtureStages.GROUP) => {
    fixture.value = null
    fixtureMatches.value[stage] = []
  }

  const resetStore = () => {
    fixture.value = null
    fixtureGroups.value = []
    resetFixtureMatches()
  }

  const resetFixtureMatches = () => {
    fixtureMatches.value = {
      [FixtureStages.GROUP]: [],
      [FixtureStages.ROUND]: [],
      [FixtureStages.QUARTER]: [],
      [FixtureStages.SEMI]: [],
      [FixtureStages.FINAL]: [],
    }
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
    resetFixtureMatch,
    resetDashboard,
  }
})
