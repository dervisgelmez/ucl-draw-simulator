import { ref } from 'vue'
import { defineStore } from 'pinia'
import { useApiRequest } from '@/composables/useApiRequest.ts'
import type { Fixture } from '@/types/fixture.ts'

export const useFixtureStore = defineStore('fixture', () => {
  const fixture = ref<Fixture | null>(null)

  const fetchFixture = async () => {
    if (fixture.value) {
      return;
    }

    const { data } = await useApiRequest().request('api/fixtures', { method: 'GET' })
    fixture.value = data.value ?? null
  }

  return {
    fixture,
    fetchFixture
  }
})
