<template>
  <swiper
    :modules="modules"
    :slides-per-view="sliderPreview"
    :space-between="space"
    navigation
    :pagination="{ clickable: true }"
    class="main-caro h-full rounded-[30px]"
  >
    <swiper-slide v-for="(item, i) in carousels" :key="i">
      <div
        class="single-slide bg-no-repeat bg-cover bg-center rounded-md h-[100%]"
        :style="{
          backgroundImage: 'url(' + item.img + ')',
        }"
      >
      <div class="max-w-[320px] pt-20 ltr:pl-20 rtl:pr-20" v-if="logo">
        <router-link to="/">
          <img :src="logoWhite" alt="" class="mb-10" v-if="!this.$store.themeSettingsStore.isDark" />
          <img :src="logoWhite" alt="" class="mb-10" v-else />
        </router-link>
      </div>
        <div class="pt-20 container text-center px-4 slider-content h-full w-full min-h-[300px] rounded-md flex flex-col items-center justify-center text-white" >
          <div class="max-w-sm">
            <h2 v-if="item.title" class="text-xl font-medium text-white">
              {{ item.title }}
            </h2>
            <p v-if="item.description" class="text-sm">
              {{ item.description }}
            </p>
          </div>
        </div>
      </div>
    </swiper-slide>
  </swiper>
</template>
<script>
// import Swiper core and required modules
import {
  Navigation,
  Pagination,
  Scrollbar,
  A11y,
  Autoplay,
  EffectFade,
} from "swiper";

// Import Swiper Vue.js components
import { Swiper, SwiperSlide } from "swiper/vue";
import logoWhite from "@/assets/images/logo/Logo_White.png"
import logo from "@/assets/images/logo/Logo_Black.png"

// Import Swiper styles
import "swiper/css";
import "swiper/css/navigation";
import "swiper/css/pagination";
import "swiper/css/scrollbar";
import "swiper/css/effect-fade";

// Import Swiper styles
export default {
  components: {
    Swiper,
    SwiperSlide,
    
  },
  data() {
    return {
      logoWhite, logo
    }
  },
  props: {
    sliderPreview: {
      type: Number,
      default: 1,
    },
    space: {
      type: Number,
      default: 0,
    },

    carousels: {
      type: Array,
      default: [],
    },
    logo: {
      type: Boolean
    }
  },

  setup() {
    return {
      modules: [Navigation, Pagination, Scrollbar, A11y, Autoplay, EffectFade],
    };
  },
};
</script>

<style lang="scss">
.main-caro {
  .swiper-button-next:after,
  .swiper-button-prev:after {
    font-family: unset !important;
    @apply rtl:rotate-180;
  }
  .swiper-button-next:after {
    content: url("https://api.iconify.design/heroicons-outline/chevron-right.svg?color=white&width=24");
  }
  .swiper-button-prev:after {
    content: url("https://api.iconify.design/heroicons-outline/chevron-left.svg?color=white&width=24");
  }
  .swiper-pagination-bullet {
    height: 2px;
    width: 24px;
    @apply rounded-[1px] bg-white bg-opacity-70;
    &.swiper-pagination-bullet-active {
      @apply bg-opacity-100;
    }
  }
}
</style>
