<template>
  <router-link :to="{ name: 'home' }">
    <img
      src="@/assets/images/logo/logo_m_gold.svg"
      alt="" class="w-[70%]"
      v-if="!this.$store.themeSettingsStore.isDark"
    />

    <img
      src="@/assets/images/logo/logo_m_gold.svg"
      alt="" class="w-[70%]"
      v-if="this.$store.themeSettingsStore.isDark"
    />
  </router-link>
</template>
<script></script>
<style scoped>

</style>
