<template>
    <div>

        <div class="grid grid-cols-12 gap-5">
            <div class="lg:col-span-8 col-span-12">
                <Card title="Exchange Money">

                    <form @submit.prevent="onSubmit" class="space-y-4" enctype="multipart/form-data">

                        <div class="grid lg:grid-cols-1 md:grid-cols-1 grid-cols-1 gap-5">
                            <InputGroup type="number" label="Exchange From" placeholder="Amount" v-model="amount"
                                :error="amountError" classInput="h-[48px]" @change="get_amount(amount, currency, xCurrency)">
                                <template v-slot:prepend>
                                    <div class="fromGroup relative" :class="`${currencyError ? 'has-error' : ''}  `">
                                        <select name="swift" class="input-control block w-full focus:outline-none h-[48px]"
                                            v-model="currency"  @change="get_amount(amount, currency, xCurrency)">
                                            <option value="">Select A Currency</option>
                                            <option v-for="item in currencies" :key="item" :value="item.name">{{ item.name }}</option>
                                        </select>

                                        <span v-if="currencyError" class="mt-2 text-danger-500 block text-sm">{{ currencyError
                                        }}</span>
                                    </div>
                                </template>
                            </InputGroup>
                            <InputGroup type="text" label="Exchange From" placeholder="Exchange Amount" v-model="newAmount" isReadonly
                                :error="xAmountError" classInput="h-[48px]" :modelValue="newAmount">
                                <template v-slot:prepend>
                                     <div class="fromGroup relative" :class="`${xCurrencyError ? 'has-error' : ''}  `">
                                        <select name="swift" class="input-control block w-full focus:outline-none h-[48px]"
                                            v-model="xCurrency"  @change="get_amount(amount, currency, xCurrency)">
                                            <option value="">Select A Currency</option>
                                            <option v-for="item in currencies" :key="item" :value="item.name">{{ item.name }}</option>
                                        </select>

                                        <span v-if="xCurrencyError" class="mt-2 text-danger-500 block text-sm">{{ xCurrencyError
                                        }}</span>
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
                <Card title="Exchange History ">
                    <!-- <h5 class="text-xs font-medium">Send Money History</h5> -->
                    <ul class="space-y-3 mt-6 divide-y dark:divide-slate-700 divide-slate-100">
                        <li class="flex justify-between items-center text-xs text-slate-600 dark:text-slate-300 pt-3" v-for="item in history" v-bind:key="item">
                            <span>{{ item.notify }} <br/> {{ format_date(item.created_at) }}</span>
                            
                            <span></span>
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
import moment from 'moment';


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
            currencies: '',
            newAmount: "",
            history: ""
        }
    },
    beforeMount() {
        this.fetch_currency()
        this.fetch_history()
    },
    mounted() {
        this.currency = this.currencies ? this.currencies[0].value : "USD"
        this.xCurrency = this.currencies ? this.currencies[1].value : "EUR"
    },
    methods: {
        format_date(value) {
            return moment(value).format("Do-MMM-YYYY hh:mm A");
        },
        fetch_history() {

            let $this = this
            const toast = useToast();

            axios.post(`${import.meta.env.VITE_APP_API_URL}/customer/exchange_history`, {}, {
                headers: {
                    "Authorization": "Bearer " + this.$store.authStore.user.token
                }
            }).then(function (response) {
                // console.log(response.data)
                if (response.data?.status) {
                    $this.history = response.data.data;
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
            });
        },
        fetch_currency() {

            let $this = this
            const toast = useToast();

            axios.post(`${import.meta.env.VITE_APP_API_URL}/customer/fetch_currency`, {}, {
                headers: {
                    "Authorization": "Bearer " + this.$store.authStore.user.token
                }
            }).then(function (response) {
                // console.log(response.data)
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
            });
        },
        get_amount(amount, currency, xCurrency) {
            let from = null;
            let to = null
            if (!amount || !currency || !xCurrency) {
                return;
            }

            for (let i = 0; i <= this.currencies.length - 1; i++) {
                if (this.currencies[i].name == xCurrency) {
                    to = this.currencies[i].rate
                    break;
                }
            }

            for (let i = 0; i <= this.currencies.length - 1; i++) {
                if (this.currencies[i].name == currency) {
                    from = this.currencies[i].rate
                    break;
                }
            }

            this.newAmount = ((parseFloat(amount) / from) * to).toFixed(2)
        }
    },
    setup() {
        const schema = yup.object({
            amount: yup.number('Amount Can only be numbers').required("Amount is required"),
            xAmount: yup.number('Amount Can only be numbers').nullable("Amount is required"),
            description: yup.string().required("Description is required"),
            currency: yup.string().required(" Code is required"),
            xCurrency: yup.string().required(" Code is required"),
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
