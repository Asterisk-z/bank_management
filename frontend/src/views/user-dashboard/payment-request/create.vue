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
                                    <Select label="" :options="currencies" v-model="currency" style="width: 200px"
                                        :error="currencyError" classInput="h-[48px]" />
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
                    <!-- <h5 class="text-xs font-medium">Send Money History</h5> -->
                    <ul class="space-y-3 mt-6 divide-y dark:divide-slate-700 divide-slate-100">
                        <li class="flex justify-between items-center text-xs text-slate-600 dark:text-slate-300 pt-3">
                            <span>{{ "You sent olang@royal.com 10 USD" }} </span>
                            <span>{{ "1st of May" }}</span>
                        </li>
                        <li class="flex justify-between items-center text-xs text-slate-600 dark:text-slate-300 pt-3">
                            <span>{{ "olang@royal.com credit you 10 USD" }} </span>
                            <span>{{ "1st of May" }}</span>
                        </li>
                    </ul>
                </Card>
            </div>
        </div>
    </div>
</template>
<script>
import Breadcrumb from "@/views/components/Breadcrumbs";
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
                {
                    value: "AUD",
                    label: "AUD",
                },
                {
                    value: "EUR",
                    label: "EUR",
                },
            ],
        }
    },
    mounted() {
        this.currency = this.currencies[0].value
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
