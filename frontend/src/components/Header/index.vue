<template>
  <header :class="navbarTypeClass()">
    <div :class="`app-header md:px-6 px-[15px]  dark:bg-slate-800 shadow-base dark:shadow-base3 bg-white ${borderSwicthClass()} ${ this.$store.themeSettingsStore.navbarColor } md:py-6 py-3`"
    >
      <div class="flex justify-between items-center h-full">
        <div v-if="this.$store.themeSettingsStore.menuLayout === 'vertical'" class="flex items-center md:space-x-4 space-x-2 rtl:space-x-reverse">
          <button class="ltr:mr-5 rtl:ml-5 text-xl text-slate-900 dark:text-white" v-if="this.$store.themeSettingsStore.sidebarCollasp && window.width > 1280" @click="this.$store.themeSettingsStore.sidebarCollasp = false">
            <Icon icon="akar-icons:arrow-right" v-if="!this.$store.themeSettingsStore.direction"/>
            <Icon icon="akar-icons:arrow-left" v-if="this.$store.themeSettingsStore.direction"/>
          </button>
          <MobileLogo v-if="window.width < 1280" />
          <handle-mobile-menu v-if="window.width < 1280 && window.width > 768" />
          <SearchModal />
        </div>
        <div class="nav-tools flex items-center lg:space-x-5 space-x-3 rtl:space-x-reverse" >
          <SwitchDark />
          <Notification v-if="window.width > 768" />
          <Profile v-if="window.width > 768" />
          <handle-mobile-menu v-if="window.width < 768" />
        </div>
      </div>
    </div>
  </header>
</template>
<script>
import Profile from "./Navtools/Profile.vue";
import Notification from "./Navtools/Notification.vue";
import SwitchDark from "./Navtools/SwitchDark.vue";
import Icon from "../Icon";
import SearchModal from "./Navtools/SearchModal.vue";
import MobileLogo from "./Navtools/MobileLogo.vue";
import window from "@/mixins/window";
import HandleMobileMenu from "./Navtools/HandleMobileMenu.vue";

export default {
  mixins: [window],
  components: {
    Profile,
    Notification,
    SwitchDark,
    Icon,
    SearchModal,
    MobileLogo,
    HandleMobileMenu,
  },

  methods: {
    navbarTypeClass() {
      switch (this.$store.themeSettingsStore.navbarType) {
        case "floating":
          return "floating";
        case "sticky":
          return "sticky top-0 z-[999]";
        case "static":
          return "static";
        case "hidden":
          return "hidden";
        default:
          return "sticky top-0";
      }
    },
    borderSwicthClass() {
      if (
        this.$store.themeSettingsStore.skin === "bordered" &&
        this.$store.themeSettingsStore.navbarType !== "floating"
      ) {
        return "border-b border-gray-5002 dark:border-slate-700";
      } else if (
        this.$store.themeSettingsStore.skin === "bordered" &&
        this.$store.themeSettingsStore.navbarType === "floating"
      ) {
        return "border border-gray-5002 dark:border-slate-700";
      } else {
        return "dark:border-b dark:border-slate-700 dark:border-opacity-60";
      }
    },
  },
};
</script>
<style lang="scss" scoped>
.floating .app-header {
  @apply md:mx-6 md:my-8 mx-[15px] my-[15px] rounded-md;
}
</style>
