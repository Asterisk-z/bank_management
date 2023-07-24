<template>
  <div class="grid grid-cols-12 gap-5">
    <div class="lg:col-span-8 col-span-12">
      <Card title="Verify OTP" >
        
          <form @submit.prevent="onSubmit" class="space-y-4" enctype="multipart/form-data">

            <div class="grid lg:grid-cols-1 md:grid-cols-1 grid-cols-1 gap-5">
              <InputGroup type="text" label="OTP Code" placeholder="Code" v-model="codeOtp" :error="codeOtpError"
                classInput="h-[48px]">
              </InputGroup>
            </div>

            <button type="submit" class="btn btn-primary float-right text-center" v-if="transaction">
              {{ buttonText }}
            </button>
          </form>
      </Card>
    </div>
    <div class="lg:col-span-4 col-span-12">
      <Card title="Recent OTP Details">
        <template v-if="transaction">
                <h5 class="text-xs font-medium">You have an Active OTP</h5>
                <ul class="space-y-3 mt-6 divide-y dark:divide-slate-700 divide-slate-100">
                    <li class="flex justify-between items-center text-xs text-slate-600 dark:text-slate-300 pt-3">
                        <span>{{ transaction.notify }} </span>
                    </li>
                    <li class="flex justify-between items-center text-xs text-slate-600 dark:text-slate-300 pt-3">
                        <span>{{ transaction.created_at }}</span>
                    </li>
                </ul>
        </template>
    
      </Card>
    </div>
  </div>
</template>
<script>
import Card from "@/components/Card";
import Icon from "@/components/Icon";
import InputGroup from "@/components/InputGroup";
import Textarea from "@/components/Textarea";
import { useField, useForm } from "vee-validate";
import * as yup from "yup";
import { inject, ref } from "vue";
import { useAuthStore } from '@/store/authUser';
import { useRouter } from "vue-router";
import { useToast } from "vue-toastification";

import axios from 'axios';


export default {
  components: {
    Icon,
    InputGroup,
    Textarea,
    Card,
  },
  data() {
    return {
      transaction: "",
    }
  },
  mounted() {
    this.fetchActiveOtp();
  },
  methods: {
    fetchActiveOtp() {
        
      let $this = this
        const toast = useToast();
      
      axios.post(`${import.meta.env.VITE_APP_API_URL}/customer/get_otp`, {}, {
        headers: {
          "Authorization": "Bearer " + this.$store.authStore.user.token
        }
      }).then(function (response) {
        // console.log(response.data)
          if (response.data?.status) {
              $this.transaction = response.data.transaction;

            toast.success("OTP Found Successfully", {
                timeout: 2000,
            });

        } else {
          let message = response.data?.message[0];
          toast.error(message, {
            timeout: 4000,
          });
        }
      }).catch(function (error) {
        toast.error(error.response.data.message, {
          timeout: 5000,
        });
      });
    }
  },
  setup() {
    const schema = yup.object({
      codeOtp: yup.string().required("Code is required"),
    });
    const swal = inject("$swal");
    const toast = useToast();
    const router = useRouter();
    const auth = useAuthStore();

    const { handleSubmit } = useForm({
      validationSchema: schema,
    });

    const { value: codeOtp, errorMessage: codeOtpError } = useField("codeOtp");

    const onSubmit = handleSubmit((values) => {

      toast.info("Verifying OTP", {
        timeout: 5000,
      });

      const fromData = new FormData();
      fromData.append("code", values.codeOtp);

      axios.post(`${import.meta.env.VITE_APP_API_URL}/customer/verify_otp`, fromData, {
        headers: {
          "Authorization": "Bearer " + auth.user.token
        }
      }).then(function (response) {
        
        if (response.data?.status) {

          toast.success(response.data?.message, {
            timeout: 2000,
          });
          
          router.push("/app/user-dashboard");

        } else {
          let message = response.data?.message[0];
          toast.error(message, {
            timeout: 4000,
          });
        }
      }).catch(function (error) {
        // console.log(error);
        // console.log(error.response.data);
        toast.error(error.response.data.message, {
          timeout: 5000,
        });
      });

    });

    return {
      codeOtp,
      codeOtpError,
      onSubmit,
      buttonText: "Verify Transaction"
    };
  },
}
</script>
<style lang=""></style>
