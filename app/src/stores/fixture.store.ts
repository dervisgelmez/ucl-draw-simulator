import { ref } from 'vue'
import { defineStore } from 'pinia'
import { useApiRequest } from '@/composables/useApiRequest.ts'
import type { Fixture, FixtureGroup, FixtureMatch } from '@/types/fixture.ts'

export const useFixtureStore = defineStore('fixture', () => {
  const fixture = ref<Fixture | null>(null)
  const fixtureGroups = ref<Array<FixtureGroup>>([] as FixtureGroup[])
  const fixtureMatches = ref<Array<FixtureMatch>>([] as FixtureMatch[])

  const fetchFixture = async () => {
    if (fixture.value) {
      return;
    }

    const { data } = await useApiRequest().request('/fixtures', { method: 'GET' })
    fixture.value = data.value ?? null
  }

  const setFixtureGroups = (data: Array<FixtureGroup>) => {
    fixtureGroups.value = data
  }

  const setFixtureMatches = (data: Array<FixtureMatch>) => {
    fixtureMatches.value = data
  }

  const resetFixture = async () => {
    await useApiRequest().request(`/fixtures/${fixture.value?.id}`, { method: 'DELETE' })
    fixture.value = null
  }

  return {
    fixture,
    fixtureGroups,
    fixtureMatches,
    setFixtureGroups,
    setFixtureMatches,
    fetchFixture,
    resetFixture
  }
})
