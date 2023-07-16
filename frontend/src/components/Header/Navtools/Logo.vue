<template>
  <router-link :to="{ name: 'home' }">
    <img
      src="@/assets/images/logo/Logo_Black.png"
      alt=""
      v-if="!this.$store.themeSettingsStore.isDark"
    />

    <img
      src="@/assets/images/logo/Logo_White.png"
      alt=""
      v-if="this.$store.themeSettingsStore.isDark"
    />
  </router-link>
</template>
<script></script>
