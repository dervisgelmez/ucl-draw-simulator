<template>
  <div class="flex flex-col gap-10">
    <n-collapse>
      <n-collapse-item title="Group Stage" name="group_stage">
        <div class="p-10 border border-gray-200 rounded-lg">
          <FixtureGroupStage :fixture="fixture" />
        </div>
      </n-collapse-item>
    </n-collapse>

    ROUND 16 AREA
  </div>
</template>

<script setup lang="ts">
import type { IFixtureStageComponentsProps } from '@/types/fixture.ts'
import FixtureGroupStage from '@/components/fixture/stages/FixtureGroupStage.vue'
import { NCollapse, NCollapseItem } from 'naive-ui'

defineProps<IFixtureStageComponentsProps>()
</script>
