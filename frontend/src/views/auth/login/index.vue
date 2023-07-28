<template>
    <div class="loginwrapper">
      <div class="lg-inner-column">
        <div class="left-column p-5">
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
              <div class="text-center 2xl:mb-10 mb-4">
                <h4 class="font-medium">Welcome Back</h4>
                <div class="text-slate-500 text-base">
                  Sign in to your account
                </div>
              </div>

              <Signin />

              <div class="md:max-w-[345px] mx-auto font-normal text-slate-500 dark:text-slate-400 mt-12 text-sm" >
                Don’t have an account? Sign up
                <router-link to="/register" class="text-slate-900 dark:text-white font-medium hover:underline" >
                  Register
                </router-link>
              </div>
            </div>
            <div class="auth-footer text-center">
              Copyright 2023, RBQ All Rights Reserved.
            </div>
          </div>
        </div>
      </div>
    </div>
</template>
<script>
import Signin from "../common/Signin";
import Social from "../common/Social";
import Carousel from "@/components/Carousel";
import sideImg1 from "@/assets/images/auth/slideShow2.png";
import sideImg2 from "@/assets/images/auth/slideShow1.png";
import sideImg3 from "@/assets/images/auth/beach.jpg";
import sideImg4 from "@/assets/images/auth/siblings.jpg";
import logoWhite from "@/assets/images/logo/Logo_White.png"
import logo from "@/assets/images/logo/Logo_Black.png"

export default {
  data () {
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
        {
          img: sideImg4,
        },
      ],
    }
  },
  components: {
    Social,
    Signin,
    Carousel
  },
};
</script>
<style lang="scss"></style>
