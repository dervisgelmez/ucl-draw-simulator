<template>
  <div>
    <FixtureDashboard v-if="fixture" />
    <FixtureGenerate v-else />
  </div>
</template>

<script setup lang="ts">
import { useFixtureStore } from '@/stores/fixture.store.ts'
import FixtureDashboard from '@/components/fixture/FixtureDashboard.vue'
import { storeToRefs } from 'pinia'
import FixtureGenerate from '@/components/fixture/FixtureGenerate.vue'

const { fixture } = storeToRefs(useFixtureStore())
</script>
