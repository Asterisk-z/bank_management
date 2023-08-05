<template>
    <div>


        <div class="grid grid-cols-12 gap-5">
            <div class="lg:col-span-8 col-span-12">
                <!-- {{ users }} -->
                <Card title="Create Bank">

                    <form @submit.prevent="onSubmit" class="space-y-4" enctype="multipart/form-data">

                        <div class="grid lg:grid-cols-1 md:grid-cols-1 grid-cols-1 gap-5">
                            <InputGroup type="text" label="Name" placeholder="Name" v-model="name"
                                    :error="nameError" classInput="h-[48px]">
                            </InputGroup>

                        </div>
                        <div class="grid lg:grid-cols-3 md:grid-cols-3 grid-cols-1 gap-5">
                            <InputGroup type="text" label="Swiss Code" placeholder="Country" v-model="swissCode"
                                    :error="swissCodeError" classInput="h-[48px]">
                            </InputGroup>
                            
                            <div class="fromGroup relative" :class="`${bankCountryError ? 'has-error' : ''}  `">
                                <label :class="`inline-block input-label `">{{ 'Bank Country' }}</label>
                                <select name="swift" class="input-control block w-full focus:outline-none h-[48px]"
                                    v-model="bankCountry">
                                    <option value="">Select A Country</option>
                                    <option  v-for="item in Countries" :key="item" :value="item.label">{{ item.label }}</option>
                                </select>
                                <span v-if="bankCountryError" class="mt-2 text-danger-500 block text-sm">{{ bankCountryError
                                }}</span>
                            </div>

                            <div class="fromGroup relative" :class="`${bankCurrencyError ? 'has-error' : ''}  `">
                                <label :class="`inline-block input-label `">{{ 'Bank Currency' }}</label>
                                <select name="swift" class="input-control block w-full focus:outline-none h-[48px]"
                                    v-model="bankCurrency">
                                    <option value="">Select A Currency</option>
                                    <option v-for="item in currencies" :key="item" :value="item.name">{{ item.name }}</option>
                                </select>

                                <span v-if="bankCurrencyError" class="mt-2 text-danger-500 block text-sm">{{ bankCurrencyError
                                }}</span>
                            </div>
                        </div>
                        <div class="grid lg:grid-cols-2 md:grid-cols-2 grid-cols-1 gap-5">
                            <InputGroup type="number" label="Minimum Transfer Amount" placeholder="Minimum Transfer Amount" v-model="minimum"
                                    :error="minimumError" classInput="h-[48px]" append="$">
                            </InputGroup>
                            <InputGroup type="number" label="Maximum Transfer Amount" placeholder="Maximum Transfer Amount" v-model="maximum"
                                    :error="maximumError" classInput="h-[48px]"  append="$">
                            </InputGroup>

                        </div>
                        <div class="grid lg:grid-cols-3 md:grid-cols-3 grid-cols-1 gap-5">
                            <InputGroup type="number" label="Fixed Charge" placeholder="Fixed Charge" v-model="fixedCharge"
                                    :error="fixedChargeError" classInput="h-[48px]"  append="$">
                            </InputGroup>
                            <InputGroup type="number" label="Charge In Percentage" placeholder="Charge In Percentage" v-model="chargeInPercent"
                                    :error="chargeInPercentError" classInput="h-[48px]" append="%">
                            </InputGroup>

                            <div class="fromGroup relative" :class="`${statusError ? 'has-error' : ''}  `">
                                <label :class="`inline-block input-label `">{{ 'Status' }}</label>
                                <select name="swift" class="input-control block w-full focus:outline-none h-[48px]"
                                    v-model="status">
                                    <option value="">Select A Status</option>
                                    <option value="active">Activate</option>
                                    <option value="not_active">Deactivate</option>
                                </select>

                                <span v-if="statusError" class="mt-2 text-danger-500 block text-sm">{{ statusError
                                }}</span>
                            </div>

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
                <Card title="">

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
import FromGroup from "@/components/FromGroup";
import axios from 'axios';
import vSelect from "vue-select";
import { Countries } from "@/constant/country";
import "vue-select/dist/vue-select.css";

import moment from 'moment';

export default {
    components: {
        InputGroup,
        Textarea,
        vSelect,
        Breadcrumb,
        FromGroup,
        Card,
        Select,
        Breadcrumb,
    },
    data() {
        return {
            Countries,
            history: '',
            users: [],
            plans: [],
            selecteUser: "",
            selectedCurrency: "",
            selecteUserDetails: "",
            currencies: "",
        }
    },
    mounted() {
        this.fetch_currencies()
    },
    methods: {
        format_date(value) {
            return moment(value).format("Do-MMM-YYYY hh:mm A");
        },
        fetch_currencies() {
            let $this = this
            let data = axios.post(`${import.meta.env.VITE_APP_API_URL}/admin/fetch_currencies`, { }, {
                headers: {
                    "Authorization": "Bearer " + $this.$store.authStore.user.token
                }
            }).then(function (response) {

                if (response.data?.status) {

                    $this.currencies = response.data.currencies

                } else {
                   
                }
            }).catch(function (error) {
                if (error.response?.data?.error == 'Unauthorized') {
                    // toast.error("Session Expired", {
                    //     timeout: 3000,
                    // });
                    $this.$router.push({ name: 'Login' })
                }
            });
        }
    },

    setup() {
        const schema = yup.object({
            name: yup.string().required("Name is required"),
            swissCode: yup.string().required("Swiss Code is required"),
            bankCountry: yup.string().required("Bank COuntry is required"),
            bankCurrency: yup.string().required("Bank Currency is required"),
            fixedCharge: yup.number('Charge In Percent Can only be numbers').required("Charge In Percent is required"),
            chargeInPercent: yup.number('Charge In Percent Can only be numbers').required("Charge In Percent is required").max(100),
            minimum: yup.number('Mininum Amount Can only be numbers').required("Mininum Amount is required"),
            maximum: yup.number('Maximum Amount Can only be numbers').required("Maximum Amount is required"),
            status: yup.string().required("Status is required"), 
            description: yup.string().required("Description is required"),
        });
        const swal = inject("$swal");
        const toast = useToast();
        const router = useRouter();
        const auth = useAuthStore();

        const { handleSubmit } = useForm({
            validationSchema: schema,
        });

        const { value: name, errorMessage: nameError } = useField("name");
        const { value: swissCode, errorMessage: swissCodeError } = useField("swissCode");
        const { value: bankCountry, errorMessage: bankCountryError } = useField("bankCountry");
        const { value: bankCurrency, errorMessage: bankCurrencyError } = useField("bankCurrency");
        const { value: minimum, errorMessage: minimumError } = useField("minimum");
        const { value: maximum, errorMessage: maximumError } = useField("maximum");
        const { value: fixedCharge, errorMessage: fixedChargeError } = useField("fixedCharge");
        const { value: chargeInPercent, errorMessage: chargeInPercentError } = useField("chargeInPercent");
        const { value: status, errorMessage: statusError } = useField("status");
        const { value: description, errorMessage: descriptionError } = useField("description");

        const onSubmit = handleSubmit((values) => {

            if (parseFloat(values.minimum) > parseFloat(values.maximum)) {
                toast.info("Minimun value can not be greater than Maximun Value", {
                    timeout: 5000,
                });
                return
            }
            toast.info("Creating Bank", {
                timeout: 5000,
            });

            const fromData = new FormData();
            fromData.append("name", values.name);
            fromData.append("swift_code", values.swissCode);
            fromData.append("minimum_transfer_amount", values.minimum);
            fromData.append("maximum_transfer_amount", values.maximum);
            fromData.append("fixed_charge", values.fixedCharge);
            fromData.append("charge_in_percentage", values.chargeInPercent);
            fromData.append("descriptions", values.description);
            fromData.append("bank_currency", values.bankCurrency);
            fromData.append("bank_country", values.bankCountry);
            fromData.append("status", values.status);

            axios.post(`${import.meta.env.VITE_APP_API_URL}/admin/create_bank`, fromData, {
                headers: {
                    "Authorization": "Bearer " + auth.user.token
                }
            }).then(function (response) {

                if (response.data?.status) {

                    toast.success(response.data?.message, {
                        timeout: 2000,
                    });

                    router.push({ name: 'admin-all-banks' });

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

        });

        return {
        
            name,
            nameError,
            swissCode,
            swissCodeError,
            bankCountry,
            bankCountryError,
            bankCurrency,
            bankCurrencyError,
            minimum,
            minimumError,
            maximum,
            maximumError,
            fixedCharge,
            fixedChargeError,
            chargeInPercent,
            chargeInPercentError,
            status,
            statusError,
            description,
            descriptionError,
            onSubmit,
            buttonText: "Create"
        };
    },
}
</script>
<style lang=""></style>
