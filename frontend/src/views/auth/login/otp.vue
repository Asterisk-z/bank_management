<template>
  <div class="loginwrapper bg-slate-100 flex items-center justify-center">
    <div class="lg-inner-column">
      <div class="w-full h-full flex flex-col items-center justify-center">
        <div class="bg-white dark:bg-slate-800 relative my-[64px] mx-auto p-10 rounded-md max-w-[520px]">
          <img src="@/assets/images/logo/Logo_Gold.png" alt="" class="block mx-auto w-[200px]"
            v-if="!this.$store.themeSettingsStore.isDark" />
          <img src="@/assets/images/logo/Logo_Gold.png" alt="" class="block mx-auto w-[200px]"
            v-if="this.$store.themeSettingsStore.isDark" />
          <div class="text-center text-slate-800 dark:text-white font-medium text-base mt-4 mb-8">
            Check OTP
          </div>
          <form @submit.prevent="onSubmit" class="space-y-4">
            <Textinput label="Code" type="text" placeholder="Type your code" name="Code" v-model="code"
              :error="codeError" classInput="h-[48px]" :modelValue="fromcode" />

            <button type="submit" class="btn btn-dark block w-full text-center">
               Login
            </button>
          </form>
          <div class="text-slate-100 font-normal text-base mb-10 text-center mt-10">
            copyright @ 2023 Royal Bank Of Queenslands Group
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import Textinput from "@/components/Textinput";
import { useField, useForm } from "vee-validate";
import * as yup from "yup";
import { useRouter } from "vue-router";
import { useToast } from "vue-toastification";
import axios from 'axios';
import { useAuthStore } from '@/store/authUser';

export default {
  components: {
    Textinput,
  },
  data() {
    return {
      checkbox: false,
      fromcode: "",
    };
  },
  mounted() {

    // const toast = useToast();
    // let $this = this;
    // axios.post(`${import.meta.env.VITE_APP_API_URL}/auth/check_token`, {
    //   token: this.$route.params.token
    // }, {}).then(function (response) {

    //   if (response.data.status) {
    //     $this.fromcode = response.data.token.code
    //     toast.success("Reset Password", {
    //       timeout: 2000,
    //     });

    //   } else {
    //     toast.error("Wrong Token found", {
    //       timeout: 2000,
    //     });
    //   }
    // }).catch(function (error) {
    //   console.log(error)
    //   toast.error("User not found", {
    //     timeout: 2000,
    //   });
    // });
  },
  setup() {
    // Define a validation schema
    const schema = yup.object({
      code: yup.string().required("code is required"),
    });

    const { handleSubmit } = useForm({
      validationSchema: schema,
    });
    // No need to define rules for fields

    const toast = useToast();
    const route = useRouter();
    const auth = useAuthStore(); 
    const { value: code, errorMessage: codeError } = useField("code");


    const onSubmit = handleSubmit((values) => {


      auth.login_otp(values.code)

    });

    return {
      code,
      codeError,
      onSubmit,
    };
  },
};
</script>
<style lang=""></style>
