<template>
  <div class="mobile-sidebar bg-white dark:bg-slate-800 shadow-base">
    <div class="logo-segment flex justify-between items-center px-4 py-6">
      <router-link :to="{ name: 'home' }">
        <img :src="logo" alt="" v-if="!this.$store.themeSettingsStore.isDark" class="w-[80%]"/>
        <img :src="logoWhite" alt="" v-if="this.$store.themeSettingsStore.isDark" class="w-[80%]"/>
      </router-link>
      <span class="cursor-pointer text-slate-900 dark:text-white text-2xl" @click="toggleMsidebar" >
        <Icon icon="heroicons:x-mark"/>
      </span>
    </div>

    <div class="sidebar-menu px-4 h-[calc(100%-100px)] pb-20" data-simplebar>
        <Navmenu :items="(this.$store.authStore.user.role == 'admin') ? AdminMenuItem : UserMenuItem" />
    </div>
  </div>
</template>
<script>
import { Icon } from "@iconify/vue";
import { defineComponent } from "vue";
import { AdminMenuItem, UserMenuItem } from "@/constant/data";
import Navmenu from "./Navmenu";
import { useThemeSettingsStore } from "@/store/themeSettings";
const themeSettingsStore = useThemeSettingsStore();
import logoWhite from "@/assets/images/logo/Logo_White.png"
import logoC from "@/assets/images/logo/small_gold.svg"
import logoW from "@/assets/images/logo/small_white.png"
import logo from "@/assets/images/logo/Logo_Black.png"

export default defineComponent({
  components: {
    Icon,
    Navmenu,
  },
  data() {
    return {
      AdminMenuItem, UserMenuItem,
      logoWhite, logoC, logoW,
      logo,
      openClass: "w-[248px]",
      closeClass: "w-[72px] close_sidebar",
    };
  },
  methods: {
    toggleMsidebar() {
      themeSettingsStore.toggleMsidebar()
    },
  },
});
</script>
<style lang="scss" scoped>
.mobile-sidebar {
  @apply fixed ltr:left-0 rtl:right-0 top-0   h-full   z-[9999]  w-[280px];
}
</style>
