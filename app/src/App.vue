<template>
  <n-config-provider class="w-full h-full" :theme-overrides="themeOverrides">
    <RouterView />
  </n-config-provider>
</template>

<script setup lang="ts">
import { NConfigProvider } from 'naive-ui';
import type { GlobalThemeOverrides } from 'naive-ui';

const themeOverrides: GlobalThemeOverrides = {
  common: {
    fontSizeLarge: '0.875rem',
    fontSizeMedium: '0.875rem',
    fontSizeSmall: '0.875rem',
    fontSizeTiny: '0.875rem',
    borderRadius: '0.5rem',
    borderColor: '#D0D5DD',
    textColorDisabled: '#B5B5C3',
    placeholderColorDisabled: '#D0D4DF',
    primaryColor: '#317BFFFF',
    primaryColorHover: '#2068E8FF',
    primaryColorPressed: '#4D8DFFFF',
    primaryColorSuppl: 'rgba(61, 67, 249, 1)',
    placeholderColor: '#667085',
    heightLarge: '44px',
    heightMedium: '44px',
    heightSmall: '42px',
    heightTiny: '37px',
    textColor1: '#0A1B39',
    textColor2: '#0A1B39',
    textColor3: '#0A1B39',
    textColorBase: '#0A1B39'
  },
  Input: {
    textColor: '#0A1B39'
  },
  Tag: {
    heightMedium: '2rem'
  }
};
</script>
