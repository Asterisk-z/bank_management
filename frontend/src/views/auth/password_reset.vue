<template>
  <div class="loginwrapper bg-slate-100 flex items-center justify-center">
    <div class="lg-inner-column">
      <div class="w-full h-full flex flex-col items-center justify-center">
        <div class="bg-white dark:bg-slate-800 relative my-[64px] mx-auto p-10 rounded-md max-w-[520px]" >
          <img
            src="@/assets/images/logo/Logo_Gold.png"
            alt=""
            class="block mx-auto w-[200px]"
            v-if="!this.$store.themeSettingsStore.isDark"
          />
          <img
            src="@/assets/images/logo/Logo_Gold.png"
            alt=""
            class="block mx-auto w-[200px]"
            v-if="this.$store.themeSettingsStore.isDark"
          />
          <div
            class="text-center text-slate-800 dark:text-white font-medium text-base mt-4 mb-8"
          >
            Reset Password
          </div>
            <form @submit.prevent="onSubmit" class="space-y-4">
              <Textinput label="Email" type="email" placeholder="Type your email" name="email" v-model="email" :error="emailError" classInput="h-[48px]" :modelValue="fromEmail"  />
              
              <Textinput label="Password" type="password" placeholder="8+ characters, 1 capital letter " name="password" v-model="password" :error="passwordError" hasicon classInput="h-[48px]" />
              <Textinput label="Confirm Password" type="password" placeholder="8+ characters, 1 capital letter " name="cpassword" v-model="cPassword" :error="cPasswordError" hasicon classInput="h-[48px]" />

          <button type="submit" class="btn btn-dark block w-full text-center">
            Change Password
          </button>
        </form>
          <div
            class="text-slate-100 font-normal text-base mb-10 text-center"
          >
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

export default {
  components: {
    Textinput,
  },
  data() {
    return {
      checkbox: false,
      fromEmail: "",
    };
  },
  mounted() {
    
    const toast = useToast();
    let $this = this;
    axios.post(`${import.meta.env.VITE_APP_API_URL}/auth/check_token`, {
      token: this.$route.params.token
    }, {}).then(function (response) {

      if (response.data.status) {
        $this.fromEmail = response.data.token.email
        toast.success("Reset Password", {
          timeout: 2000,
        });

      } else {
        toast.error("Wrong Token found", {
          timeout: 2000,
        });
      }
    }).catch(function (error) {
      console.log(error)
      toast.error("User not found", {
        timeout: 2000,
      });
    });
  },
  setup() {
    // Define a validation schema
    const schema = yup.object({
      email: yup.string().required().email("Email is required"),
      password: yup.string().required("Password is  required").min(8),
      cPassword: yup.string().required("Password is  required").min(8),
    });

    const { handleSubmit } = useForm({
      validationSchema: schema,
    });
    // No need to define rules for fields

    const toast = useToast();
    const route = useRouter();
    const { value: email, errorMessage: emailError } = useField("email");
    const { value: cPassword, errorMessage: cPasswordError } = useField("cPassword");
    const { value: password, errorMessage: passwordError } = useField("password");

    
    const onSubmit = handleSubmit((values) => {

      
      let token = window.location.pathname.split('/').pop()
      axios.post(`${import.meta.env.VITE_APP_API_URL}/auth/password_reset`, {

        email: values.email,
        password: values.password,
        password_confirmation: values.cPassword,
        token: token,
      }, {}).then(function (response) {

        if (response.data.status) {

            toast.success("Password Updated Successfully", {
              timeout: 2000,
            });

            window.location.href = import.meta.env.VITE_APP_URL

        } else {
          toast.error("Wrong Token", {
            timeout: 2000,
          });
        }
      }).catch(function (error) {
        let message = error.response?.data?.message

        toast.error(message, {
          timeout: 2000,
        });
      });
    });

    return {
      email,
      emailError,
      password,
      passwordError,
      cPassword,
      cPasswordError,
      onSubmit,
    };
  },
};
</script>
<style lang=""></style>
