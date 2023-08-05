<template>
    <div>
        <div class="grid xl:grid-cols-1 grid-cols-1 gap-5">
            <Card title="Withdraw">

                <form @submit.prevent="onSubmit" class="space-y-4" enctype="multipart/form-data">

                    <div class="grid lg:grid-cols-1 md:grid-cols-1 grid-cols-1 gap-5">
                        <InputGroup type="text" label="Amount" placeholder="Amount" v-model="amount" :error="amountError"
                            classInput="h-[48px]">
                            <template v-slot:prepend>
                                <!-- <Select label="" :options="currencies" v-model="currency" style="width: 200px"
                                    :error="currencyError" classInput="h-[48px]" /> -->
                                <div class="fromGroup relative" :class="`${currencyError ? 'has-error' : ''}  `">
                                    <select name="swift" class="input-control block w-full focus:outline-none h-[48px]" v-model="currency" >
                                        <option value="">Select A Currency</option>
                                        <option v-for="item in currencies" :key="item" :value="item.name">{{ item.name }}</option>
                                    </select>

                                    <span v-if="currencyError" class="mt-2 text-danger-500 block text-sm">{{ currencyError }}</span>
                                </div>
                            </template>
                        </InputGroup>

                        <Textarea label="Description" name="pn4" placeholder="Description..." v-model="description"
                            :error="descriptionError" />
                    </div>


                    <button type="submit" class="btn btn-primary float-right text-center">
                        {{ buttonText }}
                    </button>
                </form>

            </Card>
        </div>

    </div>
</template>
<script>
import Breadcrumb from "@/views/components/Breadcrumbs";
import Card from "@/components/Card";
import InputGroup from "@/components/InputGroup";
import Textarea from "@/components/Textarea";
import { useDropzone } from "vue3-dropzone";
import Select from "@/components/Select";
import { useField, useForm } from "vee-validate";
import * as yup from "yup";
import { inject, ref } from "vue";
import { useAuthStore } from '@/store/authUser';
import { useRouter } from "vue-router";
import { useToast } from "vue-toastification";
import axios from 'axios';
import { message } from '../../../constant/data';


export default {
    components: {
        InputGroup,
        Textarea,
        Breadcrumb,
        Card,
        Select,
        Breadcrumb,
    },
    data() {
        return {
            currencies: [
                {
                    value: "USD",
                    label: "USD",
                },
            ],
        }
    },
  beforeMount() {
      this.fetch_currency()
  },
    mounted() {
        this.currency = this.currencies[0].value
    },
    methods: {
      fetch_currency() {

          let $this = this
          const toast = useToast();

          axios.post(`${import.meta.env.VITE_APP_API_URL}/customer/fetch_currency`, {}, {
              headers: {
                  "Authorization": "Bearer " + this.$store.authStore.user.token
              }
          }).then(function (response) {
              if (response.data?.status) {
                  $this.currencies = response.data.currencies;
                  console.log($this.history)

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
               
                if (error.response?.data?.error == 'Unauthorized') {
                    toast.error("Session Expired", {
                        timeout: 3000,
                    });
                    $this.$router.push({ name: 'Login' })
                }
          });
      },
    },
    setup() {
        const schema = yup.object({
            amount: yup.number('Amount Can only be numbers').required("amount is required"),
            description: yup.string().required("Description is required"),
            currency: yup.string().required("Country Code is required"),
        });
        const swal = inject("$swal");
        const toast = useToast();
        const router = useRouter();
        const auth = useAuthStore();

        const { handleSubmit } = useForm({
            validationSchema: schema,
        });

        const { value: amount, errorMessage: amountError } = useField("amount");
        const { value: description, errorMessage: descriptionError } = useField("description");
        const { value: currency, errorMessage: currencyError } = useField("currency");

        const onSubmit = handleSubmit((values) => {

            toast.info("Requesting Withdrawal", {
                timeout: 5000,
            });

            const fromData = new FormData();
            fromData.append("amount", values.amount);
            fromData.append("description", values.description);
            fromData.append("currency", values.currency);

            axios.post(`${import.meta.env.VITE_APP_API_URL}/customer/withdraw`, fromData, {
                headers: {
                    "Authorization": "Bearer " + auth.user.token
                }
            }).then(function (response) {
                if (response.data?.status) {

                    toast.success("Withdrawal Request Received Successfully", {
                        timeout: 2000,
                    });
                    
                    router.push({name: 'withdraw-requests'});

                } else {
                    let message = response.data?.message[0];
                    toast.error(message, {
                        timeout: 4000,
                    });
                }
            }).catch(function (error) {
                let message =  error?.response?.data?.message ? error?.response?.data?.message : "Sorry, We are unable to process your request"
                toast.error(message, {
                    timeout: 5000,
                });
                 
                if (error.response?.data?.error == 'Unauthorized') {
                    router.push({ name: 'Login' })
                }
            });

        });

        return {
            amount,
            amountError,
            currency,
            currencyError,
            description,
            descriptionError,
            onSubmit,
            buttonText: "Send Request"
        };
    },
}
</script>
<style lang=""></style>
