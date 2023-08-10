<template>
    <div>

        <div class="grid grid-cols-12 gap-5">
            <div class="lg:col-span-8 col-span-12">
                <Card title="Request Payment">

                    <form @submit.prevent="onSubmit" class="space-y-4" enctype="multipart/form-data">

                        <div class="grid lg:grid-cols-1 md:grid-cols-1 grid-cols-1 gap-5">
                            <InputGroup type="text" label="Email Or Account Number" placeholder="Email Or Account"
                                v-model="recipient" :error="recipientError" classInput="h-[48px]">
                            </InputGroup>
                            <InputGroup type="text" label="Amount" placeholder="Amount" v-model="amount"
                                :error="amountError" classInput="h-[48px]">
                                <template v-slot:prepend>
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
            <div class="lg:col-span-4 col-span-12">
                <Card title="Request Payment History">
                    <ul class="space-y-3 mt-6 divide-y dark:divide-slate-700 divide-slate-100">
                        <li class="flex justify-between items-center text-xs text-slate-600 dark:text-slate-300 pt-3">
                            <span>{{ "" }} </span>
                            <span>{{ "" }}</span>
                        </li>
                        <li class="flex justify-between items-center text-xs text-slate-600 dark:text-slate-300 pt-3">
                            <span>{{ "" }} </span>
                            <span>{{ "" }}</span>
                        </li>
                    </ul>
                </Card>
            </div>
        </div>
    </div>
</template>
<script>
 
import Card from "@/components/Card";
import InputGroup from "@/components/InputGroup";
import Textarea from "@/components/Textarea";
import Select from "@/components/Select";
import { useField, useForm } from "vee-validate";
import * as yup from "yup";
import { inject, ref } from "vue";
import { useAuthStore } from '@/store/authUser';
import { useRouter } from "vue-router";
import { useToast } from "vue-toastification";
import axios from 'axios';


export default {
    components: {
        InputGroup,
        Textarea,
         
        Card,
        Select,
         
    },
    data() {
        return {
            currencies: [
                {
                    value: "USD",
                    label: "USD",
                },
                {
                    value: "AUD",
                    label: "AUD",
                },
            ],
        }
    },
    mounted() {
        this.currency = this.currencies[0].value
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
                $this.$router.push({ name: 'Login' })
            }
        });
    },
    setup() {
        const schema = yup.object({
            amount: yup.number('Amount Can only be numbers').required("Amount is required"),
            description: yup.string().required("Description is required"),
            currency: yup.string().required("Country Code is required"),
            recipient: yup.string().required("Recipient is required"),
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
        const { value: recipient, errorMessage: recipientError } = useField("recipient");

        const onSubmit = handleSubmit((values) => {

            toast.info("Sending Money", {
                timeout: 5000,
            });

            const fromData = new FormData();
            fromData.append("amount", values.amount);
            fromData.append("description", values.description);
            fromData.append("currency", values.currency);
            fromData.append("recipient", values.recipient);

            axios.post(`${import.meta.env.VITE_APP_API_URL}/customer/request_payment`, fromData, {
                headers: {
                    "Authorization": "Bearer " + auth.user.token
                }
            }).then(function (response) {

                if (response.data?.status) {

                    toast.success("Payment Request Sent Successfully", {
                        timeout: 2000,
                    });
                    router.push("/app/all-requests");

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
                    router.push({ name: 'Login' })
                }
            });

        });

        return {
            amount,
            amountError,
            currency,
            currencyError,
            recipient,
            recipientError,
            description,
            descriptionError,
            onSubmit,
            buttonText: "Send Request"
        };
    },
}
</script>
<style lang=""></style>
