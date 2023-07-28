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
        <div
          class="inner-content h-full flex flex-col bg-white dark:bg-slate-800"
        >
          <div class="auth-box2 flex flex-col justify-center h-full">
            <div class="mobile-logo text-center mb-6 lg:hidden block">
              <!-- <router-link to="/"
                ><img
                  src="@/assets/images/logo/logo.svg"
                  alt=""
                  class="mx-auto"
              /></router-link> -->
            </div>
            <div class="text-center 2xl:mb-10 mb-5">
              <h4 class="font-medium mb-4">Forgot Your Password?</h4>
              <div class="text-slate-500 dark:text-slate-400 text-base">
              </div>
            </div>
            <div
              class="font-normal text-base text-slate-500 dark:text-slate-400 text-center px-2 bg-slate-100 dark:bg-slate-600 rounded py-3 mb-4 mt-10"
            >
              Enter your Email to receive a reset link!
            </div>

            <ForgotPass />
            <div
              class="md:max-w-[345px] mx-auto font-normal text-slate-500 dark:text-slate-400 2xl:mt-12 mt-8 uppercase text-sm"
            >
              
              <router-link
                to="/"
                class="text-slate-900 dark:text-white font-medium hover:underline"
              >
                Back to The Sign In
              </router-link>
              
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
import Carousel from "@/components/Carousel";
import sideImg1 from "@/assets/images/auth/slideShow2.png";
import sideImg2 from "@/assets/images/auth/slideShow1.png";
import sideImg3 from "@/assets/images/auth/beach.jpg";
import sideImg4 from "@/assets/images/auth/siblings.jpg";
import logoWhite from "@/assets/images/logo/Logo_White.png"
import logo from "@/assets/images/logo/Logo_Black.png"
import ForgotPass from "./common/forgot";

export default {
    components: {
    ForgotPass,
    Carousel
  },
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
};
</script>
<style lang="scss"></style>