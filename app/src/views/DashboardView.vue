<template>
  <div>
    <FixtureDashboard v-if="fixture" :fixture="fixture" />
    <FixtureGenerate v-else />
  </div>
</template>

<script setup lang="ts">
import { useFixtureStore } from '@/stores/fixture.store.ts'
import { storeToRefs } from 'pinia'
import FixtureDashboard from '@/components/fixture/FixtureDashboard.vue'
import FixtureGenerate from '@/components/fixture/FixtureGenerate.vue'

const { fixture } = storeToRefs(useFixtureStore())
</script>
