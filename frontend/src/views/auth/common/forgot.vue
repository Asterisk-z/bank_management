<template>
  <form @submit.prevent="onSubmit" class="space-y-4">
    <Textinput
      label="Email"
      type="email"
      placeholder="Type your email"
      name="emil"
      v-model="email"
      :error="emailError"
      classInput="h-[48px]"
    />

    <button type="submit" class="btn btn-dark block w-full text-center">
      Send recovery email
    </button>
  </form>
</template>
<script>
import Textinput from "@/components/Textinput";
import { useField, useForm } from "vee-validate";
import * as yup from "yup";
import axios from 'axios';
import { useRouter } from "vue-router";
import { useToast } from "vue-toastification";

export default {
  components: {
    Textinput,
  },
  data() {
    return {
      checkbox: false,
    };
  },
  setup() {
    // Define a validation schema
    const schema = yup.object({
      email: yup.string().required().email("Email is required"),
    });
    
    const toast = useToast();

    const { handleSubmit } = useForm({
      validationSchema: schema,
    });
    // No need to define rules for fields

    const { value: email, errorMessage: emailError } = useField("email");

    const onSubmit = handleSubmit((values) => {
      console.warn(values);
      axios.post(`${import.meta.env.VITE_APP_API_URL}/auth/forgot_password`, {

        email: values.email
       }, {}).then(function (response) {

        console.log(response)

        // if (response.data.user.status == 'active') {
        //   sessionStorage.setItem('RoyalBankUserr', JSON.stringify(response.data));

        // } else {
        //   toast.error("User not found", {
        //     timeout: 2000,
        //   });
        // }
       }).catch(function (error) {
        console.log(error)
        toast.error("User not found", {
          timeout: 2000,
        });
      });
    });

    return {
      email,
      emailError,
      onSubmit,
    };
  },
};
</script>
<style lang="scss"></style>
