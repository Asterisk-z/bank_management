<template>
    <div>
        <Breadcrumb />

        <div class="grid grid-cols-12 gap-5">
            <div class="lg:col-span-8 col-span-12">
                <Card title="Exchange Money">

                    <form @submit.prevent="onSubmit" class="space-y-4" enctype="multipart/form-data">

                        <div class="grid lg:grid-cols-1 md:grid-cols-1 grid-cols-1 gap-5">
                            <InputGroup type="text" label="Exchange From" placeholder="Amount" v-model="amount"
                                :error="amountError" classInput="h-[48px]" @change="get_amount(amount, currency, xCurrency)">
                                <template v-slot:prepend>
                                    <Select label="" :options="currencies" v-model="currency" style="width: 200px"
                                        :error="currencyError" classInput="h-[48px]"  @change="get_amount(amount, currency, xCurrency)"/>
                                </template>
                            </InputGroup>
                            <InputGroup type="text" label="Exchange From" placeholder="Exchange Amount" v-model="newAmount" isReadonly
                                :error="xAmountError" classInput="h-[48px]" :modelValue="newAmount">
                                <template v-slot:prepend>
                                    <Select label="" :options="currencies" v-model="xCurrency" style="width: 200px"
                                        :error="xCurrencyError" classInput="h-[48px]" @change="get_amount(amount, currency, xCurrency)" />
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
                <Card title="Exchange History ">
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
                    rate: 1.000000
                },
                {
                    value: "AUD",
                    label: "AUD",
                    rate:  0.983700
                },
                {
                    value: "EUR",
                    label: "EUR",
                    rate: 0.640000
                },
            ],
            newAmount: ""
        }
    },
    mounted() {
        this.currency = this.currencies[0].value
        this.xCurrency = this.currencies[1].value
    },
    methods: {
        get_amount(amount, currency, xCurrency) {
            let from = 0;
            let to = 0
            if (!amount || !currency || !xCurrency) {
                return;
            }
            if (currency == "USD") {
                from = 1.000000
            }
            if (currency == "EUR") {
                from = 0.983700
            }
            if (currency == "AUD") {
                from = 0.640000
            }
            if (xCurrency == "USD") {
                to = 1.000000
            }
            if (xCurrency == "EUR") {
                to = 0.983700
            }
            if (xCurrency == "AUD") {
                to = 0.640000
            }

            this.newAmount = (parseFloat(amount) / from) * to
            // console.log(this.newAmount)
            // let $this = this
            // const toast = useToast();

            // axios.get(`https://currency-converter5.p.rapidapi.com/currency/convert`, {
            //      params: {
            //         format: 'json',
            //         from: 'AUD',
            //         to: 'CAD',
            //         amount: '1'
            //     }
            // }, {
            //      headers: {
            //         'X-RapidAPI-Key': '43dfc6c7fdmshf30fe89a78b3d67p15d8b1jsne315605c6f8f',
            //         'X-RapidAPI-Host': 'currency-converter5.p.rapidapi.com'
            //     }
            // })
            //     .then(function (response) {
            //     console.log(response.data)
            //     if (response.data?.status) {
            //         $this.transaction = response.data.transaction;

            //         toast.success("OTP Found Successfully", {
            //             timeout: 2000,
            //         });
            //         // router.push("/app/deposit-history");
            //         // router.push("/app/manual-deposit");

            //     } else {
            //         let message = response.data?.message[0];
            //         toast.error(message, {
            //             timeout: 4000,
            //         });
            //     }
            // }).catch(function (error) {
            //     toast.error(error.response.data.message, {
            //         timeout: 5000,
            //     });
            // });
        }
    },
    setup() {
        const schema = yup.object({
            amount: yup.number('Amount Can only be numbers').required("Amount is required"),
            xAmount: yup.number('Amount Can only be numbers').nullable("Amount is required"),
            description: yup.string().required("Description is required"),
            currency: yup.string().required("Country Code is required"),
            xCurrency: yup.string().required("Country Code is required"),
        });
        const swal = inject("$swal");
        const toast = useToast();
        const router = useRouter();
        const auth = useAuthStore();

        const { handleSubmit } = useForm({
            validationSchema: schema,
        });

        const { value: amount, errorMessage: amountError } = useField("amount");
        const { value: xAmount, errorMessage: xAmountError } = useField("xAmount");
        const { value: description, errorMessage: descriptionError } = useField("description");
        const { value: currency, errorMessage: currencyError } = useField("currency");
        const { value: xCurrency, errorMessage: xCurrencyError } = useField("xCurrency");

        const onSubmit = handleSubmit((values) => {

            toast.info("Making Exchange", {
                timeout: 5000,
            });
            if (values.currency == values.xCurrency) {
                toast.error("Can not convert same currency", {
                    timeout: 2000,
                });
                return
            }

            const fromData = new FormData();
            fromData.append("amount", values.amount);
            fromData.append("description", values.description);
            fromData.append("currency", values.currency);
            fromData.append("xCurrency", values.xCurrency);

            axios.post(`${import.meta.env.VITE_APP_API_URL}/customer/exchange`, fromData, {
                headers: {
                    "Authorization": "Bearer " + auth.user.token
                }
            }).then(function (response) {
                
                if (response.data?.status) {

                    toast.success(response.data?.message, {
                        timeout: 2000,
                    });
                    // router.push("/app/deposit-history");
                    router.push("/app/otp");

                } else {
                    let message = response.data?.message[0];
                    toast.error(message, {
                        timeout: 4000,
                    });
                }
            }).catch(function (error) {
                console.log(error);
                
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
            xAmount,
            xAmountError,
            xCurrency,
            xCurrencyError,
            description,
            descriptionError,
            onSubmit,
            buttonText: "Exchange"
        };
    },
}
</script>
<style lang=""></style>
