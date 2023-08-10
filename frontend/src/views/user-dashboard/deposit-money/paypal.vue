<template>
    <div>

        <div class="grid xl:grid-cols-1 grid-cols-1 gap-5">
            <Card title="Deposit Via PayPal">
                <form @submit.prevent="onSubmit" class="space-y-4" enctype="multipart/form-data">
                    <div class="grid md:grid-cols-1 grid-cols-1 gap-5">

                        <div class="grid lg:grid-cols-1 md:grid-cols-1 grid-cols-1 gap-5">
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

                    </div>

                    <div class="grid grid-cols-1 mt-5">
                        <div class="space-y-5 m-4">
                            <button type="submit" class="btn btn-primary float-right text-center">
                                {{ buttonText }}
                            </button>
                        </div>
                    </div>

                </form>
            </Card>
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
            btcValue: "0.00",
            currencies: [
                {
                    value: "USD",
                    label: "USD",
                },
            ],
        }
    },
    mounted() {
        this.currency = this.currencies[0].value
    },
    methods: {
    },
    setup() {
        const schema = yup.object({
            amount: yup.number('Amount Can only be numbers').moreThan(10, 'Amount must be More than 10 USD').max(100000, 'Amount should not be above 100,000 USD').required("Amount is required"),
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
        const { value: btcValue, errorMessage: btcValueError } = useField("btcValue");

        const onSubmit = handleSubmit((values) => {


            toast.info("Processing Deposit", {
                timeout: 5000,
            });

            const fromData = new FormData();
            fromData.append("amount", values.amount);
            fromData.append("btc_value", values.btcValue);
            fromData.append("description", values.description);
            fromData.append("currency", values.currency);

            axios.post(`${import.meta.env.VITE_APP_API_URL}/customer/deposit_via_paypal`, fromData, {
                headers: {
                    "Authorization": "Bearer " + auth.user.token
                }
            }).then(function (response) {
                if (response.data?.status) {

                    toast.success("Deposit Received Successfully", {
                        timeout: 2000,
                    });
                    // router.push("/app/deposit-history");

                    router.push("/app/deposithistory");

                } else {
                    let message = response.data?.message[0];
                    toast.error(message, {
                        timeout: 4000,
                    });
                }
            }).catch(function (error) {
                // console.log(error);
                toast.error("Sorry, We are unable to receive your deposit", {
                    timeout: 5000,
                });
                
                if (error.response?.data?.error == 'Unauthorized') {
                    toast.error("Session Expired", {
                        timeout: 3000,
                    });
                    $this.$router.push({ name: 'Login' })
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
            btcValue: "0.00",
            btcValueError,
            onSubmit,
            buttonText: "Make Deposit"
        };
    },
}
</script>
<style lang=""></style>
