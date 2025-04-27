import { computed, ref } from 'vue'
import type { AxiosRequestConfig } from 'axios'
import axios from 'axios'
import { type ApiResponse, ApiStates } from '@/types/api.ts'

export function useApiRequest<T = never>() {
  const state = ref<ApiStates>(ApiStates.IDLE)
  const data = ref<T | null>(null)
  const message = ref<string | null>(null)

  const request = async (url: string, config?: AxiosRequestConfig) => {
    state.value = ApiStates.IDLE
    data.value = null
    message.value = null

    try {
      const { data: axiosData, status: axiosStatus } = await axios<ApiResponse>({ url, ...config })
      if (axiosStatus >= 200 && axiosStatus < 300 && axiosData.success) {
        if (axiosData.data === null) {
          state.value = ApiStates.EMPTY
        } else {
          state.value = ApiStates.SUCCESS
          data.value = axiosData.data
        }
      } else {
        state.value = ApiStates.ERROR
        message.value = axiosData.message
      }
    } catch (err: unknown) {
      state.value = ApiStates.ERROR
      console.log(`An error occurred while fetching data:\n ${err}`)
    }
  }

  const loading = computed<boolean>(() => state.value === ApiStates.LOADING)
  const success = computed<boolean>(() => state.value === ApiStates.SUCCESS)
  const empty = computed<boolean>(() => state.value === ApiStates.EMPTY)
  const error = computed<boolean>(() => state.value === ApiStates.ERROR)

  return {
    data,
    state,
    message,

    // Computed
    loading,
    success,
    empty,
    error,

    // Methods
    request
  }
}
