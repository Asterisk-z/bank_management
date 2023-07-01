<template>
  <div class="flex justify-between flex-wrap items-center">
    <Breadcrumb />
  </div>
</template>
<script setup>
import Breadcrumb from "@/components/Breadcrumbs";
</script>
<style lang="scss">
[data-headlessui-state="open"] {
  label {
    @apply ring-0 outline-none;
  }
  .date-btn {
    @apply dark:bg-slate-700 bg-slate-900 text-white;
  }
}
</style>
