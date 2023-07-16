<template>
  <router-view />
</template>

<script>
import { useThemeSettingsStore } from "@/store/themeSettings";
import { useAuthStore } from '@/store/authUser';

export default {
  mounted() {
    this.$store.themeSettingsStore = useThemeSettingsStore()
    this.$store.authStore = useAuthStore()
  }
}
</script>

<style></style>
