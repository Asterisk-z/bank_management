<template>
  <footer :class="footerClass()">
    <div class="site-footer px-6 bg-white dark:bg-slate-800 text-slate-500 dark:text-slate-300 py-4" >
      <div class="grid md:grid-cols-1 grid-cols-1 md:gap-5">
        <div class="text-center text-sm ">
          COPYRIGHT &copy; 2023 RBQ, All rights Reserved
        </div>
      </div>
    </div>
  </footer>
</template>
<script>
export default {
  methods: {
    footerClass() {
      switch (this.$store.themeSettingsStore.footerType) {
        case "sticky":
          return "sticky bottom-0 z-[999]";
        case "static":
          return "static";
        case "hidden":
          return "hidden";
      }
    },
  },
};
</script>
<style lang=""></style>
