<template>
      <div class="loginwrapper">
        <div class="lg-inner-column">
          <div class="left-column relative z-[1]">
            <Carousel
              :carousels="carousels"
              :autoplay="{
                delay: 2500,
                disableOnInteraction: false,
              }" :logo="true"
            />
          </div>
        <div class="right-column relative">
          <div  class="inner-content h-full flex flex-col bg-white dark:bg-slate-800">
            <div class="auth-box h-full flex flex-col justify-center">
              <div class="mobile-logo text-center mb-6 lg:hidden block max-w-[220px] ml-auto mr-auto">
                <router-link to="/">
                  <img :src="logo" alt="" class="mx-auto" v-if="!this.$store.themeSettingsStore.isDark"/>
                  <img :src="logoWhite" alt="" class="mx-auto" v-else />
                </router-link>
              </div>
              <div class="text-center 2xl:mb-10 mb-5">
                <h4 class="font-medium">Sign up</h4>
                <div class="text-slate-500 dark:text-slate-400 text-base">
                  Create your Account
                </div>
              </div>
              <Signup />
            <div  class="max-w-[215px] mx-auto font-normal text-slate-500 dark:text-slate-400 2xl:mt-12 mt-6  text-sm" >
              Already registered?
              <router-link to="/" class="text-slate-900 dark:text-white font-medium hover:underline" >  Log In</router-link>
            </div>
          </div>
          <div class="auth-footer text-center">
            Copyright 2023, Royal Bank All Rights Reserved.
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import Signup from "../common/Signup";
import Social from "../common/Social";
// Image Import
import logoWhite from "@/assets/images/logo/Logo_White.png"
import logo from "@/assets/images/logo/Logo_Black.png"

import Carousel from "@/components/Carousel";
import sideImg1 from "@/assets/images/auth/slideShow2.png"
import sideImg2 from "@/assets/images/auth/slideShow1.png"
import sideImg3 from "@/assets/images/auth/slideShow3.png"

export default {
  data() {
    return {
      logoWhite,
      logo,
      carousels: [
        {
          img: sideImg1,
        },
        {
          img: sideImg2,
        },
        {
          img: sideImg3,
        },
      ],
    }
  },
  components: {
    Social,
    Signup,
    Carousel
  },
};
</script >
<style lang="scss"></style>
