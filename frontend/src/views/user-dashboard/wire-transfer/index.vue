<template>
    <div>
        <Breadcrumb />

        <div class="grid grid-cols-12 gap-5">
            <div class="lg:col-span-8 col-span-12">
                <!-- {{ swift_bank }} -->
                <Card title="Wire Transfer">

                    <form @submit.prevent="onSubmit" class="space-y-4" enctype="multipart/form-data">

                        <div class="grid lg:grid-cols-3 md:grid-cols-3 grid-cols-1 gap-5">
                             <div class="fromGroup relative" :class="`${error ? 'has-error' : ''}  ${validate ? 'is-valid' : '' } `">
                                <label :class="`inline-block input-label `">{{ 'Bank' }}</label>
                                <select name="swift" class="input-control block w-full focus:outline-none h-[48px]"  @change="select_bank" v-model="selectedBank">
                                    <option value="">Select A Bank</option>
                                    <option v-for="bank in swift_bank"  :value="bank.id" v-bind:key="bank.id">{{ bank.name }}</option>
                                </select>
                            </div>
                            <InputGroup type="text" label="Swift Code" placeholder="Swift Code" v-model="swiftCode"
                                :error="swiftCodeError" classInput="h-[48px]" isReadonly>
                            </InputGroup>
                            <InputGroup type="text" label="Currency" placeholder="Currency" v-model="swiftCurrency"
                                :error="currencyError" classInput="h-[48px]" isReadonly>
                            </InputGroup>
                        </div>
                        <div class="grid lg:grid-cols-1 md:grid-cols-1 grid-cols-1 gap-5">
                            <InputGroup type="text" label="Account Holder Name" placeholder="James Doe" v-model="amount"
                                :error="amountError" classInput="h-[48px]" >
                            </InputGroup>
                        </div>
                        <div class="grid lg:grid-cols-2 md:grid-cols-2 grid-cols-1 gap-5">
                            <InputGroup type="text" label="Account Number " placeholder="Account Number " v-model="amount"
                                :error="amountError" classInput="h-[48px]" >
                            </InputGroup>
                            <InputGroup type="text" label="Amount" placeholder="Amount" v-model="amount"
                                :error="amountError" classInput="h-[48px]" >
                            </InputGroup>
                        </div>
                        <div class="grid lg:grid-cols-1 md:grid-cols-1 grid-cols-1 gap-5">
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
                <Card title="Wire Transfer History ">
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
import vSelect from "vue-select";
import "vue-select/dist/vue-select.css";


export default {
    components: {
        InputGroup,
        Textarea,
    vSelect,
        Breadcrumb,
        Card,
        Select,
        Breadcrumb,
    },
    data() {
        return {
            voptions :[
                {
                    title: "HTML5",
                    meal: "meal",
                    author: {
                        firstName: "Remy",
                        lastName: "Sharp"
                    }
                }
            ],
            currencies: [
                {
                    value: "USD",
                    label: "USD",
                    rate: 1.000000
                },
                {
                    value: "AUD",
                    label: "AUD",
                    rate: 0.983700
                },
                {
                    value: "EUR",
                    label: "EUR",
                    rate: 0.640000
                },
            ],
            swift_bank: [],
            selectedBank: "",
            selectedBankDetails: "",
            swiftCode: "",
            swiftCurrency: ""
        }
    },
    mounted() {
        this.currency = this.currencies[0].value
        this.xCurrency = this.currencies[1].value
        this.get_swift_code();
    },
    methods: { 
        select_bank(e) {
            
            let $this = this;

            for (let index = 0; index < this.swift_bank.length; index++) {
                
                if (this.swift_bank[index].id == this.selectedBank) {
                    this.selectedBankDetails = this.swift_bank[index]
                    this.swiftCode = this.selectedBankDetails.swift_code
                    this.swiftCurrency = this.selectedBankDetails.swift_code
                }
                
            }
        } ,
        get_swift_code() {
            
            let $this = this
            const toast = useToast();

            axios.post(`${import.meta.env.VITE_APP_API_URL}/customer/get_swift`, {}, {
                headers: {
                    "Authorization": "Bearer " + $this.$store.authStore.user.token
                }
            }).then(function (response) {
                
                    if (response.data?.status) {
                    
                    $this.swift_bank = response.data.banks;

                    toast.success("Bank List Successfully", {
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
        },
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
            buttonText: "Transfer"
        };
    },
}
</script>
<style lang=""></style>
