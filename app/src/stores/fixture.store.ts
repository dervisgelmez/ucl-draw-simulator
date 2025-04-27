import { defineStore } from 'pinia'
import { ref } from 'vue'

export const useFixtureStore = defineStore('fixture', () => {
  const fixture = ref()

  const generateFixture = () => {
    // TODO: generate a fixture
  }

  return {
    fixture,
    generateFixture
  }
})
