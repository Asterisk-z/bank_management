<template>
  <router-link :to="{ name: 'home' }">
    <img
      src="@/assets/images/logo/small_gold.svg"
      alt="" class="w-[70%]"
      v-if="!this.$store.themeSettingsStore.isDark"
    />

    <img
      src="@/assets/images/logo/small_white.png"
      alt="" class="w-[30px]"
      v-if="this.$store.themeSettingsStore.isDark"
    />
  </router-link>
</template>
<script></script>
<style scoped>

</style>
