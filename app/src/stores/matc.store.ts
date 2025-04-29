import { ref } from 'vue'
import { defineStore } from 'pinia'
import type { FixtureMatch } from '@/types/fixture.ts'
import { useApiRequest } from '@/composables/useApiRequest.ts'

export const useMatchStore = defineStore('match', () => {
  const match = ref<FixtureMatch | null>(null)
  const showDrawer = ref<boolean>(false)

  const { data, loading, request } = useApiRequest()

  const fetchMatch = async (id: string) => {
    showDrawer.value = true
    await request(`/matches/${id}`, { method: 'GET' })
    match.value = (data.value ?? null)
  }

  return {
    match,
    showDrawer,
    loading,
    fetchMatch
  }
})
